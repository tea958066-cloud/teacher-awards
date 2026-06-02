<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name'        => 'Most Selfless and Proactive Staff',
                'description' => 'Select the teacher who consistently helps others, takes initiative, and goes beyond expectations.',
                'order'       => 1,
            ],
            [
                'name'        => 'Most Teachable Teacher',
                'description' => 'Select the teacher who is most willing to learn, improve, receive feedback, and embrace growth.',
                'order'       => 2,
            ],
            [
                'name'        => 'Most Innovative and Creative Teacher',
                'description' => 'Select the teacher who demonstrates outstanding creativity and innovation in teaching.',
                'order'       => 3,
            ],
            [
                'name'        => 'Most Punctual Teacher',
                'description' => 'Select the teacher who consistently arrives on time and meets responsibilities promptly.',
                'order'       => 4,
            ],
            [
                'name'        => 'Most Organized Teacher',
                'description' => 'Select the teacher who demonstrates excellent planning, preparation, and organization.',
                'order'       => 5,
            ],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(
                ['name' => $data['name']],
                ['description' => $data['description'], 'order' => $data['order'], 'is_active' => true]
            );
        }
    }
}
