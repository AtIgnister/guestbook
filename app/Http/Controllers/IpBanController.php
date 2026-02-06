<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use App\Models\GuestbookEntries;
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
    public function create(Request $request, GuestbookEntryIp $entryIp)
    {
        return view("ipBans.create", [
            'entryIp' => $entryIp
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, GuestbookEntries $guestbookEntry) {
        if($request->user()->hasRole('admin')) {
            return $this->storeGlobal($request, $guestbookEntry);
        } else {
            return $this->storeLocal($request, $guestbookEntry);
        }
    }


    private function storeLocal(Request $request, GuestbookEntries $guestbookEntry)
    {
        $ipBan = new IpBan([
            'guestbook_id' => $guestbookEntry->guestbook_id,
            'is_global' => false,
        ]);

        if ($request->user()->cannot('create', $ipBan)) {
            abort(403);
        }

        $ip = $guestbookEntry->ip;

        if ($ip) {
            $ip->ipBans()->forceCreate([
                'guestbook_id' => $guestbookEntry->guestbook_id,
                'is_global' => false,
            ]);
        }

        return redirect()->route('entries.editAll')->with('success', 'User banned.');
    }

    private function storeGlobal(Request $request, GuestbookEntries $guestbookEntry)
    {
        if ($request->user()->cannot('create', IpBan::class)) {
            abort(403);
        }

        $ip = $guestbookEntry->ip;

        if ($ip) {
            $ip->ipBans()->forceCreate([
                'guestbook_id' => null,
                'is_global' => true,
            ]);
        }

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


    public function clearBans(Request $request, Guestbook $guestbook)
    {
        // Optional authorization
        if ($request->user()->cannot('clearBans', $guestbook)) {
            abort(403);
        }

        // Delete all bans linked to this guestbook
        IpBan::where('guestbook_id', $guestbook->id)
        ->where('is_global', false)
        ->delete();

        return redirect()->back()->with('success', 'All IP bans for this guestbook have been cleared.');
    }

    public function clearGlobalBans(Request $request)
    {
        if (! $request->user()->hasRole('admin')) {
            abort(403);
        }

        IpBan::where('is_global', true)->delete();

        return redirect()->back()->with('success', 'All global IP bans have been cleared.');
    }
}
