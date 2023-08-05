<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);

            Review::factory()->count($numReviews)->good()->for($book)->create();
        });
        book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);

            Review::factory()->count($numReviews)->average()->for($book)->create();
        });
        book::factory(34)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);

            Review::factory()->count($numReviews)->bad()->for($book)->create();
        });
    }
}
