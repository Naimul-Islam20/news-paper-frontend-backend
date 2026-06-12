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
        $subEditors = User::where('role', 'sub editor')
            ->where('name', '!=', 'Sub Editor')
            ->orderBy('id')
            ->get();

        if ($subEditors->isEmpty()) {
            return;
        }

        $desks = [
            'ডিজিটাল ডেস্ক',
            'রাজনীতি ডেস্ক',
            'অর্থনীতি ডেস্ক',
            'খেলাধুলা ডেস্ক',
            'আন্তর্জাতিক ডেস্ক',
            'সংস্কৃতি ডেস্ক',
            'শিক্ষা ডেস্ক',
            'স্বাস্থ্য ডেস্ক',
            'প্রযুক্তি ডেস্ক',
            'সম্পাদকীয়',
        ];

        foreach ($desks as $index => $desk) {
            $subEditor = $subEditors[$index % $subEditors->count()];

            Reporter::updateOrCreate(
                ['desk' => $desk],
                [
                    'name' => $subEditor->name,
                    'email' => $subEditor->email,
                    'phone' => $subEditor->phone,
                    'address' => 'ঢাকা, বাংলাদেশ',
                    'image' => null,
                    'status' => 'active',
                    'sub_editor_id' => $subEditor->id,
                    'created_by' => $admin?->id,
                ],
            );
        }
    }
}
