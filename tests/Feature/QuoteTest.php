<?php

namespace Tests\Feature;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    private function makeQuote(User $user, array $extra = []): Quote
    {
        return $user->quotes()->create(array_merge(['text' => 'A calm test quote', 'mood' => 'calm'], $extra));
    }

    public function test_guest_can_view_quotes(): void
    {
        $this->makeQuote(User::factory()->create());

        $this->get('/')->assertOk()->assertSee('A calm test quote');
    }

    public function test_guest_cannot_share_a_quote(): void
    {
        $this->post('/quotes', ['text' => 'Hello there', 'mood' => 'hope'])->assertRedirect('/login');

        $this->assertDatabaseCount('quotes', 0);
    }

    public function test_user_can_share_a_quote_with_a_mood(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/quotes', ['text' => 'Be kind to your future self', 'mood' => 'hope'])
            ->assertRedirect(route('quotes.index'));

        $this->assertDatabaseHas('quotes', ['user_id' => $user->id, 'text' => 'Be kind to your future self', 'mood' => 'hope']);
    }

    public function test_quote_needs_3_to_155_characters_and_a_valid_mood(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/quotes', ['text' => 'ab', 'mood' => 'hope'])->assertSessionHasErrors('text');
        $this->actingAs($user)->post('/quotes', ['text' => str_repeat('a', 156), 'mood' => 'hope'])->assertSessionHasErrors('text');
        $this->actingAs($user)->post('/quotes', ['text' => 'Valid text', 'mood' => 'angry'])->assertSessionHasErrors('mood');
        $this->actingAs($user)->post('/quotes', ['text' => 'Valid text'])->assertSessionHasErrors('mood');

        $this->assertDatabaseCount('quotes', 0);
    }

    public function test_owner_can_edit_and_delete_their_quote(): void
    {
        $user = User::factory()->create();
        $quote = $this->makeQuote($user);

        $this->actingAs($user)
            ->patch("/quotes/{$quote->id}", ['text' => 'Edited quote text', 'mood' => 'philosophy'])
            ->assertRedirect(route('quotes.index'));
        $this->assertDatabaseHas('quotes', ['id' => $quote->id, 'text' => 'Edited quote text', 'mood' => 'philosophy']);

        $this->actingAs($user)->delete("/quotes/{$quote->id}")->assertRedirect(route('quotes.index'));
        $this->assertDatabaseMissing('quotes', ['id' => $quote->id]);
    }

    public function test_other_users_cannot_edit_or_delete_a_quote(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $quote = $this->makeQuote($owner);

        $this->actingAs($other)->patch("/quotes/{$quote->id}", ['text' => 'Hacked text', 'mood' => 'hope'])->assertForbidden();
        $this->actingAs($other)->delete("/quotes/{$quote->id}")->assertForbidden();

        $this->assertDatabaseHas('quotes', ['id' => $quote->id, 'text' => 'A calm test quote']);
    }

    public function test_like_toggles_once_per_user(): void
    {
        $quote = $this->makeQuote(User::factory()->create());
        $fan = User::factory()->create();

        $this->actingAs($fan)->post("/quotes/{$quote->id}/like");
        $this->assertSame(1, $quote->likedBy()->count());

        $this->actingAs($fan)->post("/quotes/{$quote->id}/like");
        $this->assertSame(0, $quote->likedBy()->count());
    }

    public function test_insight_of_the_day_is_shown(): void
    {
        $this->makeQuote(User::factory()->create(), ['text' => 'The only quote today']);

        $this->get('/')->assertOk()->assertSee('Insight of the Day');
    }
    public function test_user_can_save_a_quote_to_my_insights(): void
{
    $user = User::factory()->create();
    $quote = $this->makeQuote(User::factory()->create(), ['text' => 'Saved for later']);

    $this->actingAs($user)->post("/quotes/{$quote->id}/save");
    $this->actingAs($user)->get('/my-insights')->assertOk()->assertSee('Saved for later');

    $this->actingAs($user)->post("/quotes/{$quote->id}/save");
    $this->actingAs($user)->get('/my-insights')->assertDontSee('Saved for later');
}
}