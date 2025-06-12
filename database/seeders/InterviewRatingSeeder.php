<?php

namespace Database\Seeders;

use App\Enums\InterviewRating as EnumsInterviewRating;
use App\Models\InterviewRating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterviewRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use delete instead of truncate to avoid foreign key constraint issues
        InterviewRating::query()->delete();

        foreach (EnumsInterviewRating::cases() as $status) {
            InterviewRating::create([
                'rating_code' => $status->value,
                'rating_desc' => strtolower($status->label()),
            ]);
        }
    }
}
