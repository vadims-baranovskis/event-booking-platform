<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'category' => 'Culture',
                'title' => "Strūklaku uzvedums 'Zaigo'",
                'description' => 'An evening fountain show with music, lights and a calm summer atmosphere.',
                'location' => 'Ogre',
                'event_date' => '2026-08-03',
                'price' => 35,
                'available_tickets' => 120,
                'image' => 'images/events/zaigo-ogre.png',
                'is_active' => true,
            ],
            [
                'category' => 'Business',
                'title' => 'Marketing Shake 2026',
                'description' => 'A business and marketing event for people interested in digital growth.',
                'location' => 'Rīga',
                'event_date' => '2026-05-22',
                'price' => 299,
                'available_tickets' => 80,
                'image' => 'images/events/marketing-shake-2025.png',
                'is_active' => true,
            ],
            [
                'category' => 'Family',
                'title' => "Festivāls 'Sniegavīru kāzas'",
                'description' => 'A winter festival for families with performances, activities and decorations.',
                'location' => 'Rīga',
                'event_date' => '2026-01-22',
                'price' => 15,
                'available_tickets' => 200,
                'image' => 'images/events/sniegaviru-kazas.png',
                'is_active' => true,
            ],
            [
                'category' => 'Entertainment',
                'title' => 'WinterCon IX',
                'description' => 'A convention for fans of games, cosplay, comics and pop culture.',
                'location' => 'Rīga',
                'event_date' => '2026-01-19',
                'price' => 35,
                'available_tickets' => 150,
                'image' => 'images/events/wintercon-ix.png',
                'is_active' => true,
            ],
            [
                'category' => 'Food',
                'title' => 'Golden Wines Festival',
                'description' => 'A wine tasting festival with selected drinks, food and live atmosphere.',
                'location' => 'Rīga',
                'event_date' => '2026-05-09',
                'price' => 59,
                'available_tickets' => 95,
                'image' => 'images/events/golden-wines-festival.png',
                'is_active' => true,
            ],
            [
                'category' => 'Sport',
                'title' => 'Nordic Kite Fest 2026',
                'description' => 'Outdoor kite festival with shows, workshops and activities near the water.',
                'location' => 'Vilnius',
                'event_date' => '2026-08-01',
                'price' => 60,
                'available_tickets' => 180,
                'image' => 'images/events/nordic-kite-fest.png',
                'is_active' => true,
            ],
            [
                'category' => 'Food',
                'title' => 'Tallinn Craft Beer Weekend 2026',
                'description' => 'Craft beer event with breweries, tasting sessions and food stands.',
                'location' => 'Tallinn',
                'event_date' => '2026-06-13',
                'price' => 135,
                'available_tickets' => 70,
                'image' => 'images/events/tallinn-craft-beer-weekend-2025.png',
                'is_active' => true,
            ],
            [
                'category' => 'Music',
                'title' => 'Tallinn Rock Festival 2026',
                'description' => 'A rock music festival with several bands and a large concert area.',
                'location' => 'Tallinn',
                'event_date' => '2026-06-28',
                'price' => 246,
                'available_tickets' => 110,
                'image' => 'images/events/tallinn-rock-festival-2025.png',
                'is_active' => true,
            ],
            [
                'category' => 'Music',
                'title' => 'Festivāls Saldus Saule 2026',
                'description' => 'A Latvian music festival with concerts and summer festival atmosphere.',
                'location' => 'Saldus',
                'event_date' => '2026-07-27',
                'price' => 40,
                'available_tickets' => 220,
                'image' => 'images/events/saldus-saule-2025.png',
                'is_active' => true,
            ],
            [
                'category' => 'Music',
                'title' => 'Festivāls Laima RendezVous',
                'description' => 'A music event in Jūrmala with popular performers and a summer mood.',
                'location' => 'Jūrmala',
                'event_date' => '2026-07-27',
                'price' => 50,
                'available_tickets' => 130,
                'image' => 'images/events/laima-rendezvous.png',
                'is_active' => true,
            ],
            [
                'category' => 'Music',
                'title' => 'Õllesummer 2026',
                'description' => 'A summer festival with music, food, drinks and entertainment areas.',
                'location' => 'Tallinn',
                'event_date' => '2026-07-30',
                'price' => 70,
                'available_tickets' => 160,
                'image' => 'images/events/ollesummer-2025.png',
                'is_active' => true,
            ],
        ];

        foreach ($events as $eventData) {
            $category = Category::where('name', $eventData['category'])->first();

            if ($category) {
                Event::updateOrCreate(
                    ['title' => $eventData['title']],
                    [
                        'category_id' => $category->id,
                        'description' => $eventData['description'],
                        'location' => $eventData['location'],
                        'event_date' => $eventData['event_date'],
                        'price' => $eventData['price'],
                        'available_tickets' => $eventData['available_tickets'],
                        'image' => $eventData['image'],
                        'is_active' => $eventData['is_active'],
                    ]
                );
            }
        }
    }
}