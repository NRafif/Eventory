<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $organizers = User::where('role', 'organizer')->get();

        $events = [
            // Upcoming Events
            [
                'title' => 'Web Development Bootcamp 2025',
                'description' => "Ikutan bootcamp web development intensif 3 hari yang bakal ngebahas framework modern, best practices, dan hands-on projects. Belajar React, Vue.js, dan Laravel langsung dari para ahlinya!\n\nYang bakal kamu pelajari:\n- Framework JavaScript modern\n- Backend development pakai Laravel\n- Design dan optimasi database\n- Dasar-dasar deployment dan DevOps\n\nCocok banget buat pemula sampai developer intermediate yang mau level up skill-nya!",
                'location' => 'Innovation Hub, Bandung',
                'event_date' => now()->addDays(7),
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'quota' => 50,
                'status' => 'published',
            ],
            [
                'title' => 'Digital Marketing Summit 2025',
                'description' => "Temukan tren terbaru di digital marketing, strategi social media, dan content creation. Networking sama para pemimpin industri dan belajar strategi yang bisa langsung dipraktekkin buat ngembangin bisnis online kamu.\n\nTopik yang dibahas:\n- Strategi SEO dan SEM\n- Social media marketing\n- Content marketing dan storytelling\n- Analytics dan pengukuran ROI\n\nAda keynote speaker dari perusahaan tech ternama lho!",
                'location' => 'Grand Ballroom, Jakarta Convention Center',
                'event_date' => now()->addDays(14),
                'start_time' => '08:30:00',
                'end_time' => '18:00:00',
                'quota' => 200,
                'status' => 'published',
            ],
            [
                'title' => 'AI & Machine Learning Workshop',
                'description' => "Workshop hands-on yang bakal ngajarin kamu dasar-dasar artificial intelligence dan machine learning. Bikin model ML beneran dan pahami aplikasi praktisnya di dunia bisnis.\n\nHighlight workshop:\n- Pengenalan Python untuk ML\n- Supervised dan unsupervised learning\n- Dasar-dasar neural networks\n- Studi kasus real-world\n\nJangan lupa bawa laptop ya, siap-siap coding!",
                'location' => 'Tech Campus, Surabaya',
                'event_date' => now()->addDays(21),
                'start_time' => '10:00:00',
                'end_time' => '16:00:00',
                'quota' => 40,
                'status' => 'published',
            ],
            [
                'title' => 'Startup Pitch Competition',
                'description' => "Tunjukkin ide startup kamu ke calon investor dan menangkan funding! Terbuka untuk semua startup tech inovatif dan entrepreneur.\n\nHadiah:\n- Juara 1: Funding IDR 100.000.000\n- Juara 2: Funding IDR 50.000.000\n- Juara 3: Funding IDR 25.000.000\n\nPlus kesempatan mentorship sama entrepreneur sukses!",
                'location' => 'Business Innovation Center, Yogyakarta',
                'event_date' => now()->addDays(28),
                'start_time' => '13:00:00',
                'end_time' => '18:00:00',
                'quota' => 30,
                'status' => 'published',
            ],
            [
                'title' => 'Mobile App Development Masterclass',
                'description' => "Belajar bikin aplikasi mobile profesional pakai Flutter dan React Native. Dari konsep sampai deployment di iOS dan Android.\n\nYang bakal kamu dapet:\n- Teknik cross-platform development\n- Prinsip UI/UX design untuk mobile\n- State management dan integrasi API\n- Publishing ke App Store dan Play Store\n\nCocok buat developer yang udah punya basic programming.",
                'location' => 'Digital Innovation Lab, Semarang',
                'event_date' => now()->addDays(35),
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'quota' => 35,
                'status' => 'published',
            ],
            [
                'title' => 'Cybersecurity Awareness Seminar',
                'description' => "Pengetahuan cybersecurity penting buat bisnis dan individu. Belajar cara melindungi data dan sistem kamu dari ancaman modern.\n\nAgenda seminar:\n- Landscape ancaman cyber saat ini\n- Best practices untuk proteksi data\n- Perencanaan incident response\n- Compliance dan regulasi\n\nGratis dan dapet sertifikat partisipasi!",
                'location' => 'University Auditorium, Medan',
                'event_date' => now()->addDays(42),
                'start_time' => '14:00:00',
                'end_time' => '17:00:00',
                'quota' => 100,
                'status' => 'published',
            ],
            [
                'title' => 'UI/UX Design Sprint',
                'description' => "Design sprint intensif 2 hari yang fokus ke user experience dan interface design. Belajar metodologi design thinking dan bikin project yang layak masuk portfolio.\n\nYang bakal kamu pelajari:\n- User research dan personas\n- Wireframing dan prototyping\n- Design systems dan components\n- Metode usability testing\n\nPerfect buat designer dan product manager!",
                'location' => 'Creative Space, Denpasar',
                'event_date' => now()->addDays(49),
                'start_time' => '10:00:00',
                'end_time' => '18:00:00',
                'quota' => 25,
                'status' => 'published',
            ],
            [
                'title' => 'Cloud Computing Fundamentals',
                'description' => "Pengenalan teknologi cloud termasuk AWS, Azure, dan Google Cloud. Belajar arsitektur cloud, deployment, dan optimasi biaya.\n\nOutline course:\n- Model layanan cloud (IaaS, PaaS, SaaS)\n- Perbandingan cloud providers\n- Strategi migrasi\n- Security dan compliance\n\nAda hands-on labs juga!",
                'location' => 'Tech Training Center, Makassar',
                'event_date' => now()->addDays(56),
                'start_time' => '09:00:00',
                'end_time' => '16:00:00',
                'quota' => 45,
                'status' => 'published',
            ],

            // Past Events (Completed)
            [
                'title' => 'Tech Talk: Future of Web 3.0',
                'description' => "Diskusi menarik tentang masa depan internet, teknologi blockchain, dan aplikasi terdesentralisasi. Ada expert speaker dari perusahaan blockchain ternama.",
                'location' => 'Innovation Hub, Jakarta',
                'event_date' => now()->subDays(30),
                'start_time' => '14:00:00',
                'end_time' => '17:00:00',
                'quota' => 80,
                'status' => 'completed',
            ],
            [
                'title' => 'Creative Photography Workshop',
                'description' => "Belajar teknik fotografi profesional, lighting, komposisi, dan post-processing. Bawa kamera kamu dan tangkap gambar yang stunning!",
                'location' => 'Art Gallery, Bandung',
                'event_date' => now()->subDays(45),
                'start_time' => '10:00:00',
                'end_time' => '16:00:00',
                'quota' => 30,
                'status' => 'completed',
            ],
            [
                'title' => 'Entrepreneurship Bootcamp',
                'description' => "Belajar cara memulai dan mengembangkan bisnis kamu. Dari ideation sampai execution, covering business models, funding, dan strategi growth.",
                'location' => 'Business Center, Surabaya',
                'event_date' => now()->subDays(60),
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'quota' => 60,
                'status' => 'completed',
            ],
        ];

        foreach ($events as $index => $eventData) {
            $organizer = $organizers[$index % $organizers->count()];
            
            $event = Event::create([
                'organizer_id' => $organizer->id,
                'title' => $eventData['title'],
                'slug' => \Illuminate\Support\Str::slug($eventData['title']) . '-' . \Illuminate\Support\Str::random(6),
                'description' => $eventData['description'],
                'location' => $eventData['location'],
                'event_date' => $eventData['event_date'],
                'start_time' => $eventData['start_time'],
                'end_time' => $eventData['end_time'],
                'quota' => $eventData['quota'],
                'registered_count' => 0,
                'status' => $eventData['status'],
            ]);

            // Add some registered participants for past events
            if ($event->status === 'completed') {
                $registeredCount = rand(20, $event->quota);
                $event->update(['registered_count' => $registeredCount]);
            }
        }
    }
}