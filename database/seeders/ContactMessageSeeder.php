<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        if (! class_exists(ContactMessage::class)) {
            return;
        }

        $samples = [
            [
                'name' => 'Demo Reader 1',
                'email' => 'reader1@example.com',
                'subject' => 'প্রিন্ট সংস্কার সম্পর্কে',
                'message' => 'আপনাদের প্রিন্ট সংস্করণে আরও স্থানীয় সংবাদ দেখতে চাই।',
                'status' => 'unread',
            ],
            [
                'name' => 'Demo Reader 2',
                'email' => 'reader2@example.com',
                'subject' => 'ওয়েবসাইট পারফরম্যান্স',
                'message' => 'মোবাইলে সাইটটি খুব ভালো কাজ করছে।',
                'status' => 'read',
            ],
        ];

        foreach ($samples as $data) {
            ContactMessage::firstOrCreate(
                [
                    'email' => $data['email'],
                    'subject' => $data['subject'],
                ],
                $data,
            );
        }
    }
}

