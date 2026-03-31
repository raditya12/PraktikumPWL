<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        $posts = [
            [
                'title' => 'Getting Started with Laravel Filament',
                'body' => 'Laravel Filament is a great way to build admin panels quickly.',
                'color' => '#3b82f6',
                'published' => true,
                'tags' => ['laravel', 'filament', 'php'],
            ],
            [
                'title' => 'Mastering CSS Grid and Flexbox',
                'body' => 'Modern web design relies heavily on flexible layouts.',
                'color' => '#10b981',
                'published' => true,
                'tags' => ['css', 'frontend', 'design'],
            ],
            [
                'title' => 'Introduction to UI/UX Principles',
                'body' => 'Understanding user behavior is key to creating effective interfaces.',
                'color' => '#f59e0b',
                'published' => false,
                'tags' => ['ux', 'ui', 'design'],
            ],
        ];

        foreach ($posts as $postData) {
            Post::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'category_id' => $categories->random()->id,
                'color' => $postData['color'],
                'body' => $postData['body'],
                'published' => $postData['published'],
                'published_at' => $postData['published'] ? now() : null,
                'tags' => $postData['tags'],
            ]);
        }
    }
}
