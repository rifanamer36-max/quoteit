<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $sara = User::factory()->create(['name' => 'Sara Ali', 'email' => 'sara@example.com']);
        $omar = User::factory()->create(['name' => 'Omar Khalid', 'email' => 'omar@example.com']);

        $quotes = [
            [$sara, 'hope', 'Every sunrise is a quiet promise.'],
            [$sara, 'calm', 'Breathe in slowly; the day can wait.'],
            [$omar, 'philosophy', 'Questions are doors, and answers are only rooms.'],
            [$omar, 'motivation', 'Start small, start today.'],
            [$sara, 'motivation', 'Progress is a habit, not a mood.'],
            [$omar, 'hope', 'Even a small light changes the whole room.'],
            [$sara, 'philosophy', 'To understand something is to feel it fall into place.'],
            [$omar, 'calm', 'Silence is also a way of listening.'],
        ];

        foreach ($quotes as [$author, $mood, $text]) {
            $quote = $author->quotes()->create(['text' => $text, 'mood' => $mood]);

            // The other user likes it
            $quote->likedBy()->attach($author->is($sara) ? $omar->id : $sara->id);
        }
    }
}
