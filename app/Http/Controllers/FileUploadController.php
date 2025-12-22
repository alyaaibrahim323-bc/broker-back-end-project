<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Sales;




class FileUploadController extends Controller
{
    public function importCSV(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');
            $header = fgetcsv($handle, 1000, ',');

            $requiredColumns = [
                'id', 'property_name', 'project_id', 'type', 'size', 'price', 'location',
                'location_link', 'description', 'list_of_description', 'images',
                'down_payment', 'installment_options', 'rooms', 'bathrooms', 'has_garden',
                'garden_size', 'has_roof', 'roof_size', 'status', 'created_at', 'updated_at', 'developer_id', 'sales_id'
            ];

            if (array_diff($requiredColumns, $header)) {
                return redirect()->back()->with('error', 'The columns in the CSV file do not match the database columns.');
            }

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $data = array_combine($header, $row);

                // Check and handle missing property_name
                if (empty($data['property_name'])) {
                    $data['property_name'] = 'Unknown Property'; // قيمة افتراضية
                }

                // Create the unit
                $unit = Unit::create([
                    'id' => $data['id'],
                    'property_name' => $data['property_name'],
                    'project_id' => $data['project_id'],
                    'type' => $data['type'],
                    'size' => $data['size'],
                    'price' => $data['price'],
                    'location' => $data['location'],
                    'location_link' => $data['location_link'],
                    'description' => $data['description'],
                    'list_of_description' => $data['list_of_description'],
                    'images' => json_encode($data['images']),
                    'down_payment' => $data['down_payment'],
                    'installment_options' => $data['installment_options'],
                    'rooms' => $data['rooms'],
                    'bathrooms' => $data['bathrooms'] ?? null,
                    'has_garden' => $data['has_garden'] ?? null,
                    'garden_size' => $data['garden_size'] ?? null,
                    'has_roof' => $data['has_roof'] ?? null,
                    'roof_size' => $data['roof_size'] ?? null,
                    'status' => $data['status'],
                    'created_at' => $data['created_at'] ?? now(),
                    'updated_at' => $data['updated_at'] ?? now(),
                    'developer_id' => $data['developer_id'],
                ]);

                // Link sales_id if present
                if (!empty($data['sales_id'])) {
                    DB::table('sales_units')->insert([
                        'sales_id' => $data['sales_id'],
                        'unit_id' => $unit->id,
                        'assigned_date' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            fclose($handle);
            return redirect()->back()->with('success', 'Data imported successfully.');
        }

        return redirect()->back()->with('error', 'No file was uploaded.');
    }
}
