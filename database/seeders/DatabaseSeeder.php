<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            EventSeeder::class,
            RegistrationSeeder::class,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📧 Login Credentials:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('👑 Admin:');
        $this->command->info('   Email: admin@eventhub.com');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('🎪 Organizers:');
        $this->command->info('   Email: tech@eventhub.com');
        $this->command->info('   Email: arts@eventhub.com');
        $this->command->info('   Email: business@eventhub.com');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('🎫 Participants:');
        $this->command->info('   Email: john@example.com');
        $this->command->info('   Email: jane@example.com');
        $this->command->info('   (and 13 more participants)');
        $this->command->info('   Password: password');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}