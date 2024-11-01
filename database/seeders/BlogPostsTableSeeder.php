<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("public/images/jis.csv"), "r");
        $firstline = true; 
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                // Assuming the correct columns for title, content, etc.
                $title = $data[10] ?? 'Untitled';  // Adjust index based on title column
                $content = $data[12] ?? '';  // Adjust index based on content column
                $slug = Str::slug($title);  // Generate slug from title
                $author = $data[14] ?? 'Unknown';  // Adjust index based on author column
                //$published_at = $data[6] ?? null;  // Adjust index based on published date column
                $published_at_raw = $data[6] ?? null;

                // Validate published_at format
                $published_at = null;
                if ($published_at_raw && strtotime($published_at_raw)) {
                    $published_at = date('Y-m-d H:i:s', strtotime($published_at_raw));
                }
                DB::table('blog_posts')->insert([
                    "title" => $title,
                    "content" => $content,
                    "slug" => $slug,
                    "author" => $author,
                    "published_at" => $published_at,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }
            $firstline = false;
        }
    }
}
