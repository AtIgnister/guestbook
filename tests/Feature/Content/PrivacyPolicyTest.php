<?php

use App\Models\PrivacyPolicy;

function createPrivacyPolicy(string $content = "This is a test privacy policy.", string $changeSummary = "Initial draft."): PrivacyPolicy
{
    return PrivacyPolicy::create([
        "content" => $content,
        "change_summary" => $changeSummary
    ]);
}

test('privacy policy page is displayed', function () {
    createPrivacyPolicy()->publish();
    $this->get(route('privacy-policy.index'))->assertOk();
});

test('privacy policy creation page renders for admin', function () {
    $user = userWithRole('admin');
    $this->actingAs($user)->get(route('privacy-policy.create'))->assertOk();
});

test('privacy policy edit page renders for admin', function () {
    $user = userWithRole('admin');
    $policy = createPrivacyPolicy();
    $this->actingAs($user)->get(route('privacy-policy.edit', $policy))->assertOk();
});

test('privacy policy edit all drafts page renders for admin', function () {
    $user = userWithRole('admin');
    $this->actingAs($user)->get(route('privacy-policy.editAllDrafts'))->assertOk();
});

test('previous privacy policy page is displayed', function () {
    createPrivacyPolicy()->publish();
    $this->get(route('privacy-policy.show', PrivacyPolicy::first()))->assertOk();
});

test('hidden privacy policy page shows explainer', function () {
    $policy = createPrivacyPolicy()->publish();

    $policy->visible = false;
    $policy->save();

    $this->get(route('privacy-policy.show', $policy))
        ->assertOk()
        ->assertViewIs('legal.policyHidden');
});

test('privacy policy list page is displayed with one entry', function () {
    createPrivacyPolicy()->publish();
    $this->get(route('privacy-policy.list'))->assertOk();
});

test('privacy policy list page is displayed with multiple entries', function () {
    createPrivacyPolicy("Privacy policy 1", "Change 1")->publish();
    createPrivacyPolicy("Privacy policy 2", "Change 2")->publish();
    $this->get(route('privacy-policy.list'))->assertOk();
});

test('privacy policy returns 404 if no current policy exists', function () {
    $this->get(route('privacy-policy.index'))->assertNotFound();
});

test('privacy policy list returns 404 if no current policy exists', function () {
    $this->get(route('privacy-policy.list'))->assertNotFound();
});