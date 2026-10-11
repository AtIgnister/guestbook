<?php

function inviteData(array $overrides = []): array
{
    return array_merge([
        'email' => 'test@test.com',
        'role' => 'user',
    ], $overrides);
}

test('confirm invite screen can be rendered', function () {
    $user = userWithRole('admin');

    $response = $this->actingAs($user)->get(route('admin.invite'));

    $response->assertOk();
    $response->assertViewIs('admin.invite');
});

test('only admins may create invites', function (string $role, bool $allowed) {
    $user = userWithRole($role);

    expect($user->can('create', \App\Models\Invite::class))
        ->toBe($allowed);
})->with([
    'admin' => ['admin', true],
    'user' => ['user', false]
]);

test('invite can be sent', function () {
    $user = userWithRole('admin');

    $response = $this->actingAs($user)->post(route('admin.invite.create'), inviteData());

    $this->assertDatabaseHas('invites', inviteData());

    $response->assertRedirect(route('dashboard'));

    $response->assertSessionHas(
        'success',
        '<b>Success!</b> An invite with level user has been sent to test@test.com'
    );
});

test('invite cannot be sent if email is already registered', function () {
    $user = userWithRole('user');

    $admin = userWithRole('admin');

    $response = $this->actingAs($admin)
        ->from(route('admin.invite'))
        ->post(route('admin.invite.create'), inviteData(['email' => $user->email]));

    $response->assertRedirect(route('admin.invite'));

    $this->assertDatabaseMissing('invites', [
        'email' => $user->email,
    ]);

    $response->assertSessionHasErrors([
        'email' => 'The email has already been taken.',
    ]);
});

test('invite cannot be sent if user is not admin', function () {
    $user = userWithRole('user');

    expect($user->can('create', \App\Models\Invite::class))
        ->toBeFalse();

    $response = $this->actingAs($user)
        ->post(route('admin.invite.create'), inviteData());

    $this->assertDatabaseMissing('invites', inviteData());

    $response->assertForbidden();
});

test('invite cannot be sent if user is not authenticated', function () {
    $response = $this->post(route('admin.invite.create'), inviteData());

    $this->assertDatabaseMissing('invites', inviteData());

    $response->assertRedirect(route('login'));
});


use Illuminate\Notifications\Channels\MailChannel;

it('does not create a new invite if sending the notification fails', function () {
    $user = userWithRole('admin');

    // Simulate the email channel failing.
    $mailChannel = Mockery::mock(MailChannel::class);

    $mailChannel->shouldReceive('send')
        ->once()
        ->andThrow(new RuntimeException('SMTP server unavailable'));


    $this->app->instance(MailChannel::class, $mailChannel);
    $response = $this->actingAs($user)->post(route('admin.invite.create'), inviteData());
    $response->assertRedirect(route('dashboard'));

    $this->assertDatabaseMissing('invites', inviteData());

    $response->assertSessionHas(
        'error',
        '<b>Error!</b> Try again later'
    );
});