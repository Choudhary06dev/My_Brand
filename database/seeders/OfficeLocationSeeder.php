<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\OfficeLocation::create([
            'title' => 'Karachi Regional Office',
            'address' => 'Plot 45-C, 24th Commercial Street, DHA Phase 2 Extension',
            'city' => 'Karachi',
            'country' => 'Pakistan',
            'email' => 'info@example.com',
            'phone' => '+92-21-34567890',
            'status' => 1,
            'sequence' => 1,
        ]);

        \App\Models\OfficeLocation::create([
            'title' => 'Faisalabad Production Unit',
            'address' => 'Sargodha Road, near Motorway Interchange',
            'city' => 'Faisalabad',
            'country' => 'Pakistan',
            'email' => 'info@example.com',
            'phone' => '+92-41-1234567',
            'status' => 1,
            'sequence' => 2,
        ]);

        \App\Models\OfficeLocation::create([
            'title' => 'Islamabad Sales Center',
            'address' => 'Office 12, 3rd Floor, Beverly Centre, Blue Area',
            'city' => 'Islamabad',
            'country' => 'Pakistan',
            'email' => 'info@example.com',
            'phone' => '+92-51-9876543',
            'status' => 1,
            'sequence' => 3,
        ]);
    }
}
