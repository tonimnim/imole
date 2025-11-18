<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            // Agriculture & Farming
            'Crop Production',
            'Animal Husbandry',
            'Poultry Farming',
            'Swine Production',
            'Cattle Rearing',
            'Goat Farming',
            'Sheep Farming',
            'Fish Farming (Aquaculture)',
            'Beekeeping (Apiculture)',
            'Dairy Farming',

            // Horticulture
            'Floriculture',
            'Vegetable Gardening',
            'Fruit Production',
            'Nursery Management',
            'Landscape Gardening',
            'Organic Farming',
            'Hydroponics',
            'Greenhouse Management',

            // Forestry & Environment
            'Forestry',
            'Agroforestry',
            'Silviculture',
            'Tree Nursery',
            'Environmental Conservation',
            'Soil Conservation',
            'Water Management',
            'Sustainable Agriculture',

            // Agribusiness
            'Agricultural Marketing',
            'Farm Management',
            'Agricultural Economics',
            'Value Addition',
            'Post-Harvest Handling',
            'Agricultural Processing',

            // Modern Farming
            'Precision Agriculture',
            'Smart Farming',
            'Irrigation Systems',
            'Pest Management',
            'Fertilizer Management',
            'Seed Production',

            // Entrepreneurship & Business
            'Entrepreneurship',
            'Business Management',
            'Digital Marketing',
            'Financial Literacy',
            'Leadership Skills',
            'Project Management',

            // Technology & ICT
            'Computer Literacy',
            'Mobile Apps for Farmers',
            'E-Commerce',
            'Social Media Marketing',
            'Data Analysis',
            'Agricultural Technology',

            // Vocational Skills
            'Carpentry',
            'Welding',
            'Tailoring & Fashion',
            'Food Processing',
            'Bakery & Confectionery',
            'Beauty & Cosmetology',
            'Plumbing',
            'Electrical Installation',
            'Motor Vehicle Mechanics',
            'Masonry & Construction',

            // Health & Nutrition
            'Nutrition & Dietetics',
            'Food Safety',
            'Public Health',
            'First Aid',
            'Maternal Health',
            'Child Care',

            // Education & Capacity Building
            'Adult Literacy',
            'Financial Education',
            'Cooperative Management',
            'Community Development',
            'Gender Equality',
            'Youth Empowerment',
        ];

        foreach ($topics as $topic) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($topic)],
                ['name' => $topic]
            );
        }

        $this->command->info('Successfully created ' . count($topics) . ' agricultural and vocational topics!');
    }
}
