<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmbedGuestbookController extends Controller
{
    public function show(Guestbook $guestbook)
    {
        return view('embed.guestbook', compact('guestbook'));
    }

    public function store(Request $request, Guestbook $guestbook)
    {
        $rules = [
            'name' => 'required|max:255',
            'comment' => 'required|max:20000',
            'website' => 'nullable|url',
            'captcha' => 'required|captcha_api:' . $request->input('key') . ',math',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid captcha',
            ]);
        }

        $entry = $guestbook->entries()->create([
            'name' => $request->input('name'),
            'comment' => $request->input('comment'),
            'website' => $request->input('website'),
            'approved' => !$guestbook->requires_approval,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Entry created successfully!',
            'entry' => $entry,
        ]);
    }
}
