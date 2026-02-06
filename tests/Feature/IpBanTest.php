<?php

use App\Models\User;
use App\Models\IpBan;
use App\Models\Guestbook;
use App\Models\GuestbookEntries;
use App\Models\GuestbookEntryIp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin']);
});

test('non admin can create a local ip ban', function () {
    $user = User::factory()->create();
    $guestbook = Guestbook::factory()->create([
    'user_id' => $user->id,
    ]);
    $entry = GuestbookEntries::factory()->create([
        'guestbook_id' => $guestbook->id,
    ]);

    GuestbookEntryIp::factory()->create([
        'guestbook_entries_id' => $entry->id,
    ]);

    $this->actingAs($user)
        ->post(route('ipBans.store', $entry))
        ->assertRedirect(route('entries.editAll'));

    $this->assertDatabaseHas('ip_bans', [
        'guestbook_id' => $entry->guestbook->id,
        'is_global' => false,
    ]);
});

test('admin can create a global ip ban', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $entry = GuestbookEntries::factory()->create();

    GuestbookEntryIp::factory()->create([
        'guestbook_entries_id' => $entry->id,
    ]);

    $this->actingAs($admin)
        ->post(route('ipBans.store', $entry))
        ->assertRedirect(route('entries.editAll'));

    $this->assertDatabaseHas('ip_bans', [
        'guestbook_id' => null,
        'is_global' => true,
    ]);
});

test('user without permission cannot delete an ip ban', function () {
    $user = User::factory()->create();
    $ipBan = IpBan::factory()->create();

    $this->actingAs($user)
        ->delete(route('ipBans.destroy', $ipBan))
        ->assertForbidden();
});

test('authorized user can delete an ip ban', function () {
    $user = User::factory()->create();

    $guestbook = Guestbook::factory()->create([
        'user_id' => $user->id
    ]);

    $entryIp = GuestbookEntryIp::factory()->create();

    $ipBan = IpBan::factory()->create([
        'guestbook_entry_ip_id' => $entryIp->id,
        'guestbook_id' => $guestbook->id,
        'is_global' => false
    ]);

    $this->actingAs($user)
        ->delete(route('ipBans.destroy', $ipBan))
        ->assertRedirect();

    $this->assertDatabaseMissing('ip_bans', [
        'id' => $ipBan->id,
    ]);
});

test('admin can clear global ip bans', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $entry = GuestbookEntries::factory()->create();

    $entryIp = GuestbookEntryIp::factory()->create([
        'guestbook_entries_id' => $entry->id,
    ]);

    $entryIp->ipBans()->forceCreate([
        'guestbook_id' => null,
        'is_global' => true,
    ]);

    $this->actingAs($admin)
        ->delete(route('ipBans.clearGlobal'))
        ->assertRedirect();

    $this->assertDatabaseCount('ip_bans', 0);
});

test('user can clear local ip bans', function () {
    $user = User::factory()->create();
    $guestbook = Guestbook::factory()->create([
        'user_id' => $user->id
    ]);

    $entry = GuestbookEntries::factory()->create([
        'guestbook_id' => $guestbook->id,
    ]);

    $entryIp = GuestbookEntryIp::factory()->create([
        'guestbook_entries_id' => $entry->id,
    ]);

    $entryIp->ipBans()->forceCreate([
        'guestbook_id' => $guestbook->id,
        'is_global' => false,
    ]);

    $this->actingAs($user)
        ->delete(route('guestbooks.clearBans', $guestbook))
        ->assertRedirect();

    $this->assertDatabaseCount('ip_bans', 0);
});




