<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use App\Models\Attendance;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $participants = User::where('role', 'participant')->get();
        $events = Event::all();

        foreach ($events as $event) {
            // Determine how many registrations based on event status
            if ($event->status === 'completed') {
                $registrationCount = $event->registered_count;
            } elseif ($event->status === 'published') {
                // For upcoming events, register 30-80% of quota
                $registrationCount = rand(
                    (int)($event->quota * 0.3), 
                    (int)($event->quota * 0.8)
                );
            } else {
                continue; // Skip draft/cancelled events
            }

            // Randomly select participants
            $selectedParticipants = $participants->random(min($registrationCount, $participants->count()));

            foreach ($selectedParticipants as $participant) {
                // Create registration
                $registration = Registration::create([
                    'event_id' => $event->id,
                    'user_id' => $participant->id,
                    'status' => 'approved',
                    'registered_at' => $this->getRegistrationDate($event),
                ]);

                // For completed events, create attendance records for 70-90% of registrations
                if ($event->status === 'completed') {
                    if (rand(1, 100) <= 85) { // 85% attendance rate
                        Attendance::create([
                            'registration_id' => $registration->id,
                            'checked_in_at' => $event->event_date->setTime(
                                rand(8, 10), 
                                rand(0, 59)
                            ),
                            'checked_in_by' => $event->organizer->name,
                        ]);
                    }
                }
            }

            // Update event registered count
            $actualCount = $event->registrations()->count();
            $event->update(['registered_count' => $actualCount]);
        }
    }

    private function getRegistrationDate(Event $event)
    {
        // Registrations happen 1-30 days before event
        $daysBeforeEvent = rand(1, 30);
        return $event->event_date->copy()->subDays($daysBeforeEvent);
    }
}