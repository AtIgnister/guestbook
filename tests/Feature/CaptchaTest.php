<?php

use App\Models\Guestbook;
use App\Models\GuestbookEntries;
use App\Models\GuestbookEntryIp;
use App\Models\User;
use function Livewire\Volt\protect;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

/**
 * @property \App\Models\User $user
 * @property \App\Models\Guestbook $guestbook
 * @property \App\Models\GuestbookEntries $entry
 * @property \App\Models\GuestbookEntryIp $entryIp
 */

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->guestbook = Guestbook::factory()->create();
    $this->entry = GuestbookEntries::factory()->create([
        'guestbook_id' => $this->guestbook->id
    ]);
    $this->entryIp = GuestbookEntryIp::factory()->create([
        'guestbook_entries_id' => $this->entry->id
    ]);
});


test('user can generate image captcha', function () {
    $this->actingAs($this->user);

    // Step 1: Refresh the image captcha
    $imageResponse = $this->getJson(route('captcha.refresh'));
    $imageResponse->assertStatus(200)
                  ->assertJsonStructure(['captcha']);

    $imageData = $imageResponse->json();
    expect($imageData['captcha'])->toBeString();
});

test('user can generate audio captcha', function () {
    $this->actingAs($this->user);

    $audioResponse = $this->getJson('/api/audio-captcha/generate');
    $audioResponse->assertStatus(200)
                  ->assertJsonStructure(['token', 'mp3Link']);

    $audioData = $audioResponse->json();
    expect($audioData['token'])->toBeString();
    expect($audioData['mp3Link'])->toBeString();
});

