<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bookings = Booking::with(['user', 'property'])
            ->whereHas('user')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('property', function ($q) use ($search) {
                    $q->where('property_name', 'like', '%' . $search . '%');
                })
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('project_name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('adminUI.request.showrequest', compact('bookings'));
    }

    public function create()
    {
        $users = User::all();
        $units = Unit::all(); // تصحيح الحرف الكبير

        return view('adminUI.request.bookingscreate', compact('users', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:units,id',
            'status' => 'required|in:Pending,Confirmed,Cancelled',
            'phone_number' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'booking_date' => 'required|date',
        ]);

        Booking::create($request->all());

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully');
    }

    public function show(Booking $booking)
    {
        return view('adminUI.request.showbooking', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $users = User::all();
        $units = Unit::all(); // تصحيح الحرف الكبير
        return view('adminUI.request.bookingsedit', compact('booking', 'users', 'units'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'property_id' => 'nullable|exists:units,id',
            'status' => 'nullable|in:Pending,Confirmed,Cancelled',
            'is_final_booking' => 'nullable|boolean',
            'viewing_date' => 'nullable|date',
            'booking_date' => 'nullable|date',
            'phone_number' => 'nullable|string|max:20',
            'project_name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'developer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
         $validated['is_final_booking'] = $request->has('is_final_booking');


        $booking->update($validated);

        return redirect()->route('bookings.index')
                         ->with('success', 'Booking updated successfully');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')
                         ->with('success', 'Booking deleted successfully');
    }

    public function addAction(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'action_type' => 'required|string|in:note,status_change,price_update,other',
            'description' => 'required|string|max:500',
            'notes' => 'nullable|string',
            'field' => 'nullable|string',
            'old_value' => 'nullable',
            'new_value' => 'nullable'
        ]);

        $actions = $booking->list_of_actions ?? [];

        $newAction = [
            'type' => 'manual',
            'action_type' => $validated['action_type'],
            'description' => $validated['description'],
            'timestamp' => Carbon::now()->toDateTimeString(),
            'added_by' => Auth::id(),
            'notes' => $validated['notes'] ?? null,
            'field' => $validated['field'] ?? null,
            'old_value' => $validated['old_value'] ?? null,
            'new_value' => $validated['new_value'] ?? null
        ];

        $actions[] = $newAction;
        $booking->list_of_actions = array_slice($actions, -100);
        $booking->save();

        return back()->with('success', 'Action added successfully');
    }

    public function userBookings(Request $request)
    {
        $user = $request->user();

        $bookings = Booking::where('user_id', $user->id)
            ->with(['property' => function($query) {
                $query->select('id', 'price', 'location');
            }])
            ->orderBy('viewing_date', 'desc')
            ->get(['id', 'viewing_date', 'property_id', 'status']);

        return response()->json([
            'status' => 'success',
            'data' => [
                'bookings' => $bookings
            ]
        ]);
    }
    public function Addction(Request $request, $id)
{
    $booking = Booking::findOrFail($id);

    $request->validate([
        'action_type' => 'required|string',
        'action_date' => 'required|date',
    ]);

    $newAction = [
        'type' => $request->action_type,
        'date' => $request->action_date,
        'notes' => $request->action_notes ?? '',
        'created_at' => now()->toDateTimeString()
    ];

    $actions = $booking->list_of_actions ?? [];
    $actions[] = $newAction;

    $booking->update([
        'list_of_actions' => $actions
    ]);

    return back()->with('success', 'Action added successfully');
}
public function apiIndex(Request $request)
{
    $search = $request->input('search');

    $bookings = Booking::with(['user', 'property'])
        ->when($search, function ($query, $search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orWhereHas('property', function ($q) use ($search) {
                $q->where('property_name', 'like', '%' . $search . '%');
            })
            ->orWhere('status', 'like', '%' . $search . '%')
            ->orWhere('project_name', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return response()->json([
        'status' => 'success',
        'data' => $bookings
    ]);
}

}
