<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'Admin EventHub',
            'email' => 'admin@eventhub.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+62 812-3456-7890',
            'address' => 'Jakarta, Indonesia',
        ]);

        // Organizer Accounts
        $organizers = [
            [
                'name' => 'Tech Community Indonesia',
                'email' => 'tech@eventhub.com',
                'phone' => '+62 813-1111-2222',
                'address' => 'Bandung, West Java',
            ],
            [
                'name' => 'Creative Arts Hub',
                'email' => 'arts@eventhub.com',
                'phone' => '+62 814-3333-4444',
                'address' => 'Yogyakarta, DIY',
            ],
            [
                'name' => 'Business Network Forum',
                'email' => 'business@eventhub.com',
                'phone' => '+62 815-5555-6666',
                'address' => 'Surabaya, East Java',
            ],
        ];

        foreach ($organizers as $organizer) {
            User::create([
                'name' => $organizer['name'],
                'email' => $organizer['email'],
                'password' => Hash::make('password'),
                'role' => 'organizer',
                'phone' => $organizer['phone'],
                'address' => $organizer['address'],
            ]);
        }

        // Participant Accounts
        $participants = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Michael Johnson', 'email' => 'michael@example.com'],
            ['name' => 'Emily Brown', 'email' => 'emily@example.com'],
            ['name' => 'David Wilson', 'email' => 'david@example.com'],
            ['name' => 'Sarah Davis', 'email' => 'sarah@example.com'],
            ['name' => 'Robert Anderson', 'email' => 'robert@example.com'],
            ['name' => 'Lisa Martinez', 'email' => 'lisa@example.com'],
            ['name' => 'James Taylor', 'email' => 'james@example.com'],
            ['name' => 'Maria Garcia', 'email' => 'maria@example.com'],
            ['name' => 'William Thomas', 'email' => 'william@example.com'],
            ['name' => 'Jennifer White', 'email' => 'jennifer@example.com'],
            ['name' => 'Richard Harris', 'email' => 'richard@example.com'],
            ['name' => 'Linda Clark', 'email' => 'linda@example.com'],
            ['name' => 'Daniel Lewis', 'email' => 'daniel@example.com'],
        ];

        foreach ($participants as $participant) {
            User::create([
                'name' => $participant['name'],
                'email' => $participant['email'],
                'password' => Hash::make('password'),
                'role' => 'participant',
                'phone' => '+62 81' . rand(1, 9) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                'address' => $this->getRandomCity(),
            ]);
        }
    }

    private function getRandomCity(): string
    {
        $cities = [
            'Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang',
            'Medan', 'Makassar', 'Palembang', 'Tangerang', 'Depok',
            'Bekasi', 'Bogor', 'Malang', 'Denpasar', 'Balikpapan'
        ];

        return $cities[array_rand($cities)] . ', Indonesia';
    }
}