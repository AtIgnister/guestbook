<?php

test("index redirects to login for unauthenticated user", function() {
    $this->get(route("guestbooks.index"))->assertRedirect(route("login"));
});

test('index renders with one guestbook', function () {
    $user = userWithRole('user');
    createGuestbook($user);
    $this->actingAs($user);
    
    $response = $this->get(route('guestbooks.index'))->assertOk();
});

test('index renders with multiple guestbooks', function () {
    $user = userWithRole('user');

    createGuestbook($user);
    createGuestbook($user);
    createGuestbook($user);
    createGuestbook($user);
    createGuestbook($user);

    $this->actingAs($user);
    
    $response = $this->get(route('guestbooks.index'))->assertOk();
});

test("guestbook index only renders guestbooks belonging to user", function () {
    $user = userWithRole("user");
    $guestbook = createGuestbook($user);
    $standaloneGuestbook = standaloneGuestbook();
    $this->actingAs($user);

    $response = $this->get(route('guestbooks.index'))->assertOk();
    
    $response->assertViewHas('guestbooks', function ($guestbooks) use ($guestbook, $standaloneGuestbook) {
        return $guestbooks->contains('id', $guestbook->id)
            && ! $guestbooks->contains('id', $standaloneGuestbook->id);
    });
});

test('create form redirects to login for unauthenticated user', function () {
    $this->get(route("guestbooks.create"))->assertRedirect(route("login"));
});

test('unauthenticated user cannot delete guestbooks', function () {
    $guestbook = standaloneGuestbook();

    $this->delete(route('guestbooks.destroy', $guestbook))
        ->assertRedirect(route('login'));

    $this->assertDatabaseHas('guestbooks', [
        'id' => $guestbook->id,
    ]);
});

test('create form renders for authenticated user', function() {
    $user = userWithRole("user");
    $this->actingAs($user);
    $this->get(route("guestbooks.create"))->assertOk();
});

test('show form is stubbed', function() {
    $user = userWithRole("user");
    $guestbook = createGuestbook($user);
    $this->actingAs($user);

    $this->get(route("guestbooks.show", $guestbook))->assertStatus(404);
});