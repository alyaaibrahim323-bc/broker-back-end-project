<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Unit;
use App\Models\Project;
use App\Models\Developer;
use Illuminate\Http\Request;
use App\Models\SalesUnit;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\unitevent;
use App\Models\Notification;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Storage;
use App\Events\DashboardNotificationEvent;
use Exception;







class UnitController extends Controller
{
    
    /**
     * Add a unit to the authenticated user's favorites.
     *
     * @param int $unitId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addFavorite($unitId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $unit = Unit::find($unitId);
        if (!$unit) {
            return response()->json(['message' => 'Unit not found.'], 404);
        }

        try {
            $user->favoriteUnits()->attach($unitId);
            return response()->json(['message' => 'Unit added to favorites successfully.'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            // This catches the unique constraint violation if the unit is already favorited
            if ($e->getCode() == 23000) { // MySQL error code for integrity constraint violation
                return response()->json(['message' => 'Unit is already in favorites.'], 409);
            }
            return response()->json(['message' => 'Error adding unit to favorites.', 'error' => $e->getMessage()], 500);
        } catch (Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove a unit from the authenticated user's favorites.
     *
     * @param int $unitId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFavorite($unitId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $unit = Unit::find($unitId);
        if (!$unit) {
            return response()->json(['message' => 'Unit not found.'], 404);
        }

        if ($user->favoriteUnits()->detach($unitId)) {
            return response()->json(['message' => 'Unit removed from favorites successfully.'], 200);
        } else {
            return response()->json(['message' => 'Unit was not in favorites.'], 404);
        }
    }

    /**
     * Toggle a unit's favorite status for the authenticated user.
     *
     * @param int $unitId
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleFavorite($unitId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $unit = Unit::find($unitId);
        if (!$unit) {
            return response()->json(['message' => 'Unit not found.'], 404);
        }

        // `toggle` method returns an array with 'attached' and 'detached' keys
        $toggled = $user->favoriteUnits()->toggle($unitId);

        if (!empty($toggled['attached'])) {
            return response()->json(['message' => 'Unit added to favorites.', 'status' => 'favorited'], 200);
        } elseif (!empty($toggled['detached'])) {
            return response()->json(['message' => 'Unit removed from favorites.', 'status' => 'unfavorited'], 200);
        } else {
            return response()->json(['message' => 'No change in favorite status (already was or was not).', 'status' => 'no_change'], 200);
        }
    }


    /**
     * Display the authenticated user's profile, including favorited units.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        if ($user) {
            // Eager load favoriteUnits to avoid N+1 query problem
            $user->load('favoriteUnits.sales'); // Load sales for each favorited unit

            $favoriteUnitsData = $user->favoriteUnits->map(function ($unit) {
                return $this->formatUnit($unit); // Use the existing formatUnit method
            });

            $profileData = [
                'name' => $user->name ?? 'غير متوفر',
                'email' => $user->email ?? 'غير متوفر',
                'phone_number' => $user->phone_number ?? 'غير متوفر',
                'role' => $user->roles->pluck('name')->first() ?? 'غير متوفر',
                'image' => $user->image ? asset('storage/' . $user->image) : null,
                'favorite_units' => $favoriteUnitsData, // Add the favorited units here
            ];

            return response()->json($profileData, 200);
        } else {
            return response()->json(['error' => 'المستخدم غير مسجل للدخول.'], 401);
        }
    }

    public function getUnits(Request $request)
    {
        $type = $request->query('type');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $rooms = $request->query('rooms');
        $bathrooms = $request->query('bathrooms');

        $units = Unit::with('sales')
            ->when($type, function ($query) use ($type) {
                return $query->where('type', $type);
            })
            ->when($minPrice, function ($query) use ($minPrice) {
                return $query->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query) use ($maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            })
            ->when($rooms, function ($query) use ($rooms) {
                return $query->where('rooms', $rooms);
            })
            ->when($bathrooms, function ($query) use ($bathrooms) {
                return $query->where('bathrooms', $bathrooms);
            })
            ->get()
            ->map(function ($unit) {
                // معالجة الصور
                $unit->images = json_decode($unit->images);
                if (is_array($unit->images)) {
                    $unit->images = array_map(function ($image) {
                        return asset('storage/' . $image);
                    }, $unit->images);
                }

                // معالجة معلومات المبيعات
                if ($unit->sales->isNotEmpty()) {
                    $unit->sales_info = $unit->sales->map(function ($sale) {
                        return [
                            'name' => $sale->name,
                            'contact' => $sale->contact_info,
                            'image' => $sale->image ? asset('storage/' . $sale->image) : null,
                            'contact_link' => 'https://wa.me/' . $sale->contact_info,
                        ];
                    })->first();
                } else {
                    $unit->sales_info = null;
                }

                unset($unit->sales);
                return $unit;
            });

        return response()->json($units);
    }


    public function index()
    {
        $units = Unit::orderBy('id', 'desc')->get();
        $total = Unit::count();

        return view('admin.units.home', compact(['units', 'total']));
    }

    public function create()
    {
        $salespeople = Sales::all();
        $developers = Developer::all();

        $projects = Project::all();
        return view('adminUI.Properties.add-property', compact('projects','salespeople','developers'));
    }

    public function save(Request $request)
    {
        // تحقق من صحة البيانات المدخلة
        // $validator = Validator::make($request->all(), [
        //     'project_id' => 'required|exists:projects,id',
        //     'type' => 'required|string|max:255',
        //     'sales_id' => 'required|exists:sales,id',
        //     'developer_id' => 'required|exists:developers,id',
        //     'size' => 'required|integer',
        //     'price' => 'required|numeric',
        //     'down_payment' => 'nullable|numeric', // التحقق من صحة الدفعة المقدمة
        //     'installment_options' => 'nullable|string', // التحقق من صحة خيارات التقسيط
        //     'location' => 'nullable|string|max:255',
        //     'description' => 'nullable|string',
        //     'rooms' => 'required|integer',
        //     'bathrooms' => 'required|integer',
        //     'images' => 'required|array',
        //     'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'location_link' => 'nullable|url',
        //     'list_of_description' => 'nullable|string',
        //     'has_garden' => 'nullable|boolean',
        //     'garden_size' => 'nullable|integer',
        //     'has_roof' => 'nullable|boolean',
        //     'roof_size' => 'nullable|integer',
        //     'status' => 'required|in:available,reserved,sold',
        //     'property_name' => 'nullable|string|max:255',


        // ]);

        // if ($validator->fails()) {
        //     return redirect()->route('properties.add')->withInput()->withErrors($validator);
        // }

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/units', 'public');
                $images[] = $path;
            }
        }

        $list_of_description_input = $request->input('list_of_description');
        $list_of_description = $list_of_description_input
            ? json_encode(explode("\n", $list_of_description_input))
            : json_encode([]);

        // معالجة خطة التقسيط المتعددة وتحويلها إلى JSON
        $installments = $request->input('installments'); // دي هتيجي من الفورم
        $installment_options = $installments ? json_encode($installments) : null;

        $unit = Unit::create([
            'project_id' => $request->input('project_id'),
            'type' => $request->input('type'),
            'size' => $request->input('size'),
            'price' => $request->input('price'),
            'down_payment' => $request->input('down_payment', 0),
            'installment_options' => $installment_options,
            'location' => $request->input('location'),
            'description' => $request->input('description'),
            'rooms' => $request->input('rooms'),
            'bathrooms' => $request->input('bathrooms'),
            'images' => json_encode($images),
            'location_link' => $request->input('location_link'),
            'list_of_description' => $list_of_description,
            'has_garden' => $request->input('has_garden', false),
            'garden_size' => $request->input('garden_size'),
            'has_roof' => $request->input('has_roof', false),
            'roof_size' => $request->input('roof_size'),
            'status' => $request->input('status'),
            'developer_id' => $request->developer_id,
            'property_name' => $request->input('property_name'),
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'unit_key' => 0 // سيتم تحديثه تلقائياً بعد الإنشاء

        ]);
            $unit->update(['unit_key' => $unit->id]);


        DB::table('sales_units')->insert([
            'sales_id' => $request->sales_id,
            'unit_id' => $unit->id,
            'assigned_date' => now(),
            'status' => 'negotiation',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $notification = Notification::create([
            'type' => 'add',
            'message' => "add new unit  : {$unit->property_name}",
            'user_id' => Auth::id(),
        ]);

        broadcast(new NotificationEvent($notification, Auth::user()->name))->toOthers();

        session()->flash('success', 'Unit Added Successfully');
        return redirect()->route('properties.show');
    }





    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $salespeople = Sales::all();
        $developers = Developer::all();
        $projects = Project::all();
        return view('adminUI.Properties.edit-property', compact('unit','projects','salespeople','developers'));
    }



    public function update(Request $request, $id)
    {
    $unit = Unit::findOrFail($id);
    
    // 1. تحديث قواعد التحقق لخيارات التقسيط
    $validatedData = $request->validate([
    'project_id' => 'required|exists:projects,id',
    'type' => 'required|string|max:255',
    'developer_id' => 'required|exists:developers,id',
    'size' => 'required|integer',
    'price' => 'required|numeric',
    'rooms' => 'required|integer',
    'bathrooms' => 'nullable|integer',
    'status' => 'required|in:available,reserved,sold',
    
    // قواعد جديدة للتقسيط
    'installments' => 'sometimes|array',
    'installments.*.years' => 'nullable:installments|integer|min:1',
    'installments.*.initial_price' => 'nullable:installments|numeric|min:0',
    'installments.*.monthly' => 'nullable:installments|numeric|min:0',
    
    // باقي القواعد
    'location' => 'nullable|string|max:255',
    'description' => 'nullable|string',
    'images' => 'nullable|array',
    'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    'location_link' => 'nullable|url',
    'description_list' => 'nullable|string',
    'roof_area' => 'nullable|integer',
    'garden_area' => 'nullable|integer',
    'down_payment' => 'nullable|numeric',
    'property_name' => 'nullable|string|max:255',
    // 'lat' => 'nullable|float',
    // 'lng' => 'nullable|float',
    ]);
    
    // 2. معالجة الصور بشكل صحيح
    if ($request->hasFile('images')) {
    // حذف الصور القديمة أولاً
    if ($unit->images) {
        foreach (json_decode($unit->images, true) as $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }
    }
    
    // رفع الصور الجديدة
    $newImages = [];
    foreach ($request->file('images') as $image) {
        $path = $image->store('images/units', 'public');
        $newImages[] = $path;
    }
    $validatedData['images'] = json_encode($newImages);
    } else {
    $validatedData['images'] = $unit->images;
    }
    
    // 3. معالجة خيارات التقسيط بشكل صحيح
    // 3. معالجة خيارات التقسيط بشكل صحيح
    $installments = [];
    foreach ($request->input('installments', []) as $installment) {
    if (!empty($installment['years']) &&
    !empty($installment['initial_price']) &&
    !empty($installment['monthly'])) {
    
    $installments[] = [
        'years' => (int)$installment['years'],
        'initial_price' => (float)$installment['initial_price'],
        'monthly' => (float)$installment['monthly']
    ];
    }
    }
    
    $validatedData['installment_options'] = !empty($installments) ? $installments : null;
    
    $validatedData['installment_options'] = !empty($installments)
    ? $installments
    : null;
    
    
    // 4. تحديث باقي الحقول
    $validatedData['location_link'] = $request->input('location_link', $unit->location_link);
    $validatedData['description_list'] = json_encode(explode("\n", $request->input('description_list', $unit->description_list)));
    $validatedData['roof_area'] = $request->input('roof_area', $unit->roof_area);
    $validatedData['garden_area'] = $request->input('garden_area', $unit->garden_area);
    $validatedData['property_name'] = $request->input('property_name', $unit->property_name);
    $validatedData['down_payment'] = $request->input('down_payment', $unit->down_payment);
    $validatedData['lat'] = $request->input('lat', $unit->lat);
    $validatedData['lng'] = $request->input('lng', $unit->lng);
    // 5. تحديث البيانات
    $unit->update($validatedData);
    
    // 6. تحديث بيانات المبيعات
    DB::table('sales_units')->updateOrInsert(
    ['unit_id' => $unit->id],
    [
        'sales_id' => $request->sales_id,
        'assigned_date' => now(),
        'status' => 'negotiation',
        'updated_at' => now(),
    ]
    );
    
    session()->flash('success', 'Unit Updated Successfully');
    if ($request->input('redirect_to') === 'developer_properties') {
    return redirect()->route('developers.properties', ['id' => $unit->developer_id])
                 ->with('success', 'Unit updated successfully.');
    } else {
    return redirect()->route('properties.show') // أو أي صفحة تانية لو جاية من مكان عام
                 ->with('success', 'Unit updated successfully.');
    }
    }


    public function delete($id)
    {
        $unit = Unit::findOrFail($id);


        $unit->delete();
        $unitName = $unit->property_name;

        $notification = Notification::create([
            'type' => 'delete',
            'message' => "delete unit  : {$unitName}",
            'user_id' => Auth::id(),
        ]);

        broadcast(new NotificationEvent($notification,Auth::user()->name));
        session()->flash('success', 'Unit Deleted Successfully');
        return redirect()->route('admin.units');
    }

    public function search(Request $request)
    {
        $query = Unit::query();

        if ($request->has('id')) {
            $unit = $query->with('sales')->find($request->input('id'));

            if (!$unit) {
                return response()->json(['message' => 'Unit not found'], 404);
            }

            $unit->images = json_decode($unit->images);
            if (is_array($unit->images)) {
                $unit->images = array_map(function ($image) {
                    return asset('storage/' . $image);
                }, $unit->images);
            }

            if ($unit->sales->isNotEmpty()) {
                $unit->sales_info = $unit->sales->map(function ($sale) {
                    return [
                        'name' => $sale->name,
                        'contact' => $sale->contact_info,
                        'image' => $sale->image ? asset('storage/' . $sale->image) : null,
                        'contact_link' => 'https://wa.me/' . $sale->contact_info,
                    ];
                })->first();
            } else {
                $unit->sales_info = null;
            }

            $unit->description = $unit->description;
            $unit->list_of_description = json_decode($unit->list_of_description, true);

            unset($unit->sales);
            return response()->json($unit);
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        if ($request->has('project_id')) {
            $query->where('project_id', $request->input('project_id'));
        }

        if ($request->has('bathrooms')) {
            $query->where('bathrooms', $request->input('bathrooms'));
        }

        if ($request->has('rooms')) {
            $query->where('rooms', $request->input('rooms'));
        }

        if ($request->has('area_min')) {
            $query->where('size', '>=', $request->input('area_min'));
        }

        if ($request->has('area_max')) {
            $query->where('size', '<=', $request->input('area_max'));
        }

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $units = $query->with('sales')->get()->map(function ($unit) {
            $unit->images = json_decode($unit->images);
            if (is_array($unit->images)) {
                $unit->images = array_map(function ($image) {
                    return asset('storage/' . $image);
                }, $unit->images);
            }

            if ($unit->sales->isNotEmpty()) {
                $unit->sales_info = $unit->sales->map(function ($sale) {
                    return [
                        'name' => $sale->name,
                        'contact' => $sale->contact_info,
                        'image' => $sale->image ? asset('storage/' . $sale->image) : null,
                        'contact_link' => 'https://wa.me/' . $sale->contact_info,
                    ];
                })->first();
            } else {
                $unit->sales_info = null;
            }

            $unit->description = $unit->description;
            $unit->list_of_description = json_decode($unit->list_of_description, true);

            unset($unit->sales);

            return $unit;
        });

        return response()->json($units);
    }

    public function importForm()
    {
        return view('adminUI.Properties.import');
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        $header = array_map('trim', fgetcsv($handle, 1000, ','));  // التأكد من إزالة الفراغات

        $requiredColumns = [
            'property_name', 'project_id', 'type', 'size', 'price',
            'location', 'location_link', 'description', 'list_of_description',
            'images', 'down_payment', 'installment_options', 'bathrooms',
            'rooms', 'has_garden', 'garden_size', 'has_roof', 'roof_size',
            'status', 'developer_id'
        ];

        if (array_diff($requiredColumns, $header)) {
            return back()->with('error', 'أعمدة الملف غير مطابقة للمتطلبات');
        }

        $errors = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $rowNumber++;
            $data = array_combine($header, $row);

            $data['list_of_description'] = json_encode(explode("\n", $data['list_of_description']));
            $data['images'] = json_encode(explode(",", $data['images']));
            $data['has_garden'] = (int)$data['has_garden'];  // تحويل إلى 0 أو 1
            $data['has_roof'] = (int)$data['has_roof'];      // تحويل إلى 0 أو 1
            $data['project_id'] = 11;  // وضع الـ project_id الثابت كما تم تحديده

            $validator = Validator::make($data, [
                'project_id' => 'required|exists:projects,id',
                'developer_id' => 'required|exists:developers,id',
                'type' => 'required|string|max:255',
                'size' => 'required|integer',
                'price' => 'required|numeric',
                'status' => 'required|in:available,reserved,sold',
            ]);

            if ($validator->fails()) {
                $errors[] = "الصف $rowNumber: " . implode(', ', $validator->errors()->all());
                continue;
            }

            try {
                DB::transaction(function () use ($data) {
                    $unit = Unit::create($data);

                    DB::table('sales_units')->insert([
                        'sales_id' => $data['sales_id'],
                        'unit_id' => $unit->id,
                        'assigned_date' => now(),
                        'status' => 'negotiation',
                    ]);
                });
            } catch (\Exception $e) {
                $errors[] = "الصف $rowNumber: " . $e->getMessage();
            }
        }

        fclose($handle);

        if (!empty($errors)) {
            return back()->with('import_errors', $errors);
        }

        return back()->with('success', 'تم استيراد ' . ($rowNumber - 2) . ' وحدة بنجاح');
    }








    public function getDeveloperByUnit($unit_id)
    {
        $unit = Unit::find($unit_id);

        if (!$unit) {
            return response()->json(['error' => 'Unit not found.'], 404);
        }

        $developer = $unit->developer;

        if (!$developer) {
            return response()->json(['error' => 'Developer not found for this unit.'], 404);
        }

        return response()->json([
            'developer' => $developer
        ]);
    }


    public function getProjectByUnit($unit_id)
    {
        $unit = Unit::find($unit_id);

        if (!$unit) {
            return response()->json(['error' => 'Unit not found.'], 404);
        }

        $project = $unit->project;

        if (!$project) {
            return response()->json(['error' => 'Project not found for this unit.'], 404);
        }

        return response()->json([
            'project' => $project
        ]);
    }

    public function filterUnits(Request $request)
    {
        $query = Unit::query();

        // فلاتر أساسية فقط تقلل عدد النتائج (زي النوع والمشروع)
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->input('project_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $units = $query->with('sales')->get();

        if ($units->isEmpty()) {
            return response()->json(['message' => 'No units found'], 404);
        }

        $searchedUnits = $units->map(function ($unit) use ($request) {
            $score = 0;

            // السعر
            if ($request->filled('price')) {
                $score += abs($unit->price - $request->input('price'));
            }

            // المساحة
            if ($request->filled('area')) {
                $score += abs($unit->size - $request->input('area'));
            }

            // عدد الغرف
            if ($request->filled('rooms')) {
                $score += abs($unit->rooms - $request->input('rooms')) * 10;
            }

            // عدد الحمامات
            if ($request->filled('bathrooms')) {
                $score += abs($unit->bathrooms - $request->input('bathrooms')) * 10;
            }

            $unit->match_score = $score;
            return $unit;
        });

        // ترتيب الوحدات حسب أقرب وحدة
        $bestMatch = $searchedUnits->sortBy('match_score')->first();

        return response()->json($this->formatUnit($bestMatch));
    }
    private function formatUnit($unit)
{
    $unit->images = is_string($unit->images) ? json_decode($unit->images, true) : $unit->images;
    if (is_array($unit->images)) {
        $unit->images = array_map(function ($image) {
            return asset('storage/' . $image);
        }, $unit->images);
    }

    if ($unit->sales->isNotEmpty()) {
        $unit->sales_info = $unit->sales->map(function ($sale) {
            return [
                'name' => $sale->name,
                'contact' => $sale->contact_info,
                'image' => $sale->image ? asset('storage/' . $sale->image) : null,
                'contact_link' => 'https://wa.me/' . $sale->contact_info,
            ];
        })->first();
    } else {
        $unit->sales_info = null;
    }

    $unit->list_of_description = is_string($unit->list_of_description)
        ? json_decode($unit->list_of_description, true)
        : $unit->list_of_description;

    unset($unit->sales);
    unset($unit->match_score);

    return $unit;
}

public function showunit($id)
{
    $unit = Unit::with('sales')->find($id);

    if (!$unit) {
        return response()->json(['message' => 'Unit not found'], 404);
    }

    return response()->json($this->formatUnit($unit));
}



}



