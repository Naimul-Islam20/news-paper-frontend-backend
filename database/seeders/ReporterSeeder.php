<?php

namespace Database\Seeders;

use App\Models\Reporter;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReporterSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();

        $names = [
            'মোহাম্মদ রফিক',
            'সাবিনা ইয়াসমিন',
            'আরিফুল ইসলাম',
            'তানজিলা হক',
            'রাবেয়া সুলতানা',
            'ইমরান হোসেন',
            'তাহসিন আহমেদ',
            'নুসরাত জাহান',
            'মেহেদী হাসান',
            'রিদওয়ান করিম',
        ];

        foreach ($names as $index => $name) {
            Reporter::updateOrCreate(
                ['email' => "reporter".($index + 1)."@example.com"],
                [
                    'name' => $name,
                    'phone' => '+88018' . random_int(10000000, 99999999),
                    'address' => 'ঢাকা, বাংলাদেশ',
                    'image' => null,
                    'status' => 'active',
                    'created_by' => $admin?->id,
                ],
            );
        }
    }
}

