<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'user' => [
                'name' => 'John Doe',
                'avatar' => '/assets/avatar.png'
            ],
            'featuredRestaurants' => [
                [
                    'id' => 1,
                    'name' => 'NAMARASA',
                    'image' => '/assets/restaurant.png',
                    'rating' => 4.5,
                    'cuisine' => 'Indonesian',
                    'location' => 'District 1, HCMC',
                    'price_range' => '$$',
                    'delivery_time' => '25-35 min'
                ],
                [
                    'id' => 2,
                    'name' => 'Sushi Zen',
                    'image' => '/assets/restaurant2.png',
                    'rating' => 4.8,
                    'cuisine' => 'Japanese',
                    'location' => 'District 3, HCMC',
                    'price_range' => '$$$',
                    'delivery_time' => '30-40 min'
                ],
                [
                    'id' => 3,
                    'name' => 'Pizza Corner',
                    'image' => '/assets/restaurant3.png',
                    'rating' => 4.3,
                    'cuisine' => 'Italian',
                    'location' => 'District 7, HCMC',
                    'price_range' => '$$',
                    'delivery_time' => '20-30 min'
                ]
            ],
            'categories' => [
                ['name' => 'Indonesian', 'icon' => '🍛'],
                ['name' => 'Japanese', 'icon' => '🍣'],
                ['name' => 'Italian', 'icon' => '🍕'],
                ['name' => 'Chinese', 'icon' => '🥢'],
                ['name' => 'Fast Food', 'icon' => '🍔'],
                ['name' => 'Dessert', 'icon' => '🧁']
            ]
        ]);
    }

    public function menu()
    {
        return Inertia::render('Menu', [
            'restaurants' => [
                [
                    'id' => 1,
                    'name' => 'NAMARASA',
                    'image' => '/assets/restaurant.png',
                    'rating' => 4.5,
                    'cuisine' => 'Indonesian',
                    'location' => 'District 1, HCMC',
                    'price_range' => '$$',
                    'delivery_time' => '25-35 min',
                    'is_open' => true
                ],
                [
                    'id' => 2,
                    'name' => 'Sushi Zen',
                    'image' => '/assets/restaurant2.png',
                    'rating' => 4.8,
                    'cuisine' => 'Japanese',
                    'location' => 'District 3, HCMC',
                    'price_range' => '$$$',
                    'delivery_time' => '30-40 min',
                    'is_open' => true
                ],
                [
                    'id' => 3,
                    'name' => 'Pizza Corner',
                    'image' => '/assets/restaurant3.png',
                    'rating' => 4.3,
                    'cuisine' => 'Italian',
                    'location' => 'District 7, HCMC',
                    'price_range' => '$$',
                    'delivery_time' => '20-30 min',
                    'is_open' => false
                ],
                [
                    'id' => 4,
                    'name' => 'Pho Saigon',
                    'image' => '/assets/restaurant4.png',
                    'rating' => 4.6,
                    'cuisine' => 'Vietnamese',
                    'location' => 'District 1, HCMC',
                    'price_range' => '$',
                    'delivery_time' => '15-25 min',
                    'is_open' => true
                ]
            ],
            'categories' => [
                ['name' => 'All', 'active' => true],
                ['name' => 'Indonesian', 'active' => false],
                ['name' => 'Japanese', 'active' => false],
                ['name' => 'Italian', 'active' => false],
                ['name' => 'Vietnamese', 'active' => false]
            ]
        ]);
    }

    public function orders()
    {
        return Inertia::render('Orders', [
            'orders' => [
                [
                    'id' => 'R001',
                    'restaurant_name' => 'NAMARASA',
                    'date' => '2024-01-15',
                    'time' => '19:00',
                    'guests' => 2,
                    'status' => 'confirmed',
                    'total' => 450000,
                    'image' => '/assets/restaurant.png'
                ],
                [
                    'id' => 'R002',
                    'restaurant_name' => 'Sushi Zen',
                    'date' => '2024-01-20',
                    'time' => '20:30',
                    'guests' => 4,
                    'status' => 'pending',
                    'total' => 890000,
                    'image' => '/assets/restaurant2.png'
                ],
                [
                    'id' => 'R003',
                    'restaurant_name' => 'Pizza Corner',
                    'date' => '2024-01-10',
                    'time' => '18:00',
                    'guests' => 3,
                    'status' => 'completed',
                    'total' => 320000,
                    'image' => '/assets/restaurant3.png'
                ]
            ]
        ]);
    }

    public function profile()
    {
        return Inertia::render('Profile', [
            'user' => [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+62 812 3456 7890',
                'avatar' => '/assets/avatar.png',
                'member_since' => '2023-01-15',
                'total_reservations' => 25,
                'favorite_cuisine' => 'Indonesian'
            ],
            'settings' => [
                'notifications' => true,
                'email_updates' => false,
                'location_access' => true
            ]
        ]);
    }
}
