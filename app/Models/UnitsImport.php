<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;

class UnitsImport implements ToModel
{
    public function model(array $row)
    {
        return new Unit([
            'project_id' => $row[0],
            'type' => $row[1],
            'size' => $row[2],
            'price' => $row[3],
            'down_payment' => $row[4],
            'installment_options' => $row[5],
            'location' => $row[6],
            'description' => $row[7],
            'rooms' => $row[8],
            'bathrooms' => $row[9],
            'images' => $row[10],
            'location_link' => $row[11],
            'list_of_description' => $row[12],
            'has_garden' => $row[13],
            'garden_size' => $row[14],
            'has_roof' => $row[15],
            'roof_size' => $row[16],
            'status' => $row[17],
            'developer_id' => $row[18],
            'property_name' => $row[19],
        ]);
    }
}
