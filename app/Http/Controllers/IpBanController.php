<?php

namespace App\Http\Controllers;

use App\Models\GuestbookEntryIp;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\IpBan;

class IpBanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, GuestbookEntryIp $entry_ip)
    {
        return view("ipBans.create", compact("entry_ip"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, IpBan $ipBan)
    {
        if ($request->user()->cannot('create', $ipBan)) {
            abort(403);
        }

        $validated = $request->validate([
            'guestbook_entry_ip_id' => 'required|exists:guestbook_entry_ips,id',
            'ip_hash' => 'required|string',
        ]);

        // this is incredibly jank and id rather use the create function, but for some reason it tries to insert the data without is global, even though i manually assign it
        // so for now, we're doing it like this.
        // eh, who cares.
        $ipBan = new IpBan($validated);

        // Manually assign the 'is_global' field
        $ipBan->is_global = auth()->user()->hasRole("admin");

        // Save the model
        $ipBan->save();

        return redirect()->route('entries.editAll')->with('success', 'User banned.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, IpBan $ipBan)
    {
        if ($request->user()->cannot('delete', $ipBan)) {
            abort(403);
        }

        $ipBan->delete();

        return redirect()
            ->back()
            ->with('success', 'IP ban removed.');
    }
}
