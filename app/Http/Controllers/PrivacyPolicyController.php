<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Displaz current policy
     */
    public function index()
    {
        return view('legal.privacy', [
            'policy' => PrivacyPolicy::getCurrent(),
        ]);
    }

    public function list() {
        return view('legal.privacyHistory', [
            'policies' => PrivacyPolicy::publicList()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('legal.createPrivacyPolicy');
    }

    public function publish(PrivacyPolicy $privacyPolicy) {
        $privacyPolicy->publish();

        return redirect()
        ->route('privacy-policy.editAllDrafts')
        ->with('success', 'Policy published successfully.');
    }

    public function toggleVisibility(PrivacyPolicy $privacyPolicy) {
        $privacyPolicy->visible = !$privacyPolicy->visible;
        $privacyPolicy->save();

        return redirect()
        ->route('privacy-policy.editAllPublished')
        ->with('success', 'Visibility changed successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|max:20000',
            'change_summary' => 'required|max:2000',
        ]);
        
        PrivacyPolicy::create(
            $validated
        );

        return redirect()->route('privacy-policy.editAllDrafts')->with('success','Policy draft created sucessfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PrivacyPolicy $privacyPolicy)
    {
        if(!$privacyPolicy->visible) {
            return view('legal.policyHidden');
        }

        return view('legal.privacy', [
            'policy' => $privacyPolicy,
        ]);
    }

    /**
     * Display view of all drafts
     */
    public function editAllDrafts() {
        return view('legal.editAll', [
            "privacyPolicies" => PrivacyPolicy::getDrafts(),
            "enableDraftView" => true
        ]);
    }

    public function editAllPublished() {
        return view('legal.editAll', [
            "privacyPolicies" => PrivacyPolicy::getPublished(),
            "enableDraftView" => false
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrivacyPolicy $privacyPolicy)
    {
        return view('legal.editPrivacyPolicy', compact('privacyPolicy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        if($privacyPolicy->published_at) {
            return redirect()->route('privacy-policy.editAllDrafts')->with('failure',"Don't try to update already published policies. I'm not even sure how you managed to get here.");
        }

        $validated = $request->validate([
            'content' => 'required|max:20000',
            'change_summary' => 'required|max:2000',
        ]);

        $privacyPolicy->update($validated);

        return redirect()->route('privacy-policy.editAllDrafts')->with('success','Policy draft updated sucessfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        if($privacyPolicy->published_at) {
            return redirect()->route('privacy-policy.editAllDrafts')->with('failure',"Don't try to delete already published policies. I'm not even sure how you managed to get here.");
        }

        $privacyPolicy->delete();
        return redirect()->route('privacy-policy.editAllDrafts')->with('success','Policy draft deleted sucessfully.');
    }
}
