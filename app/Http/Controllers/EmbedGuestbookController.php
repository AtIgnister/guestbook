<?php

namespace App\Http\Controllers;

use App\Helpers\UserBanHelper;
use App\Models\Guestbook;
use App\Services\AudioCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmbedGuestbookController extends Controller
{
    public function index(Request $request, Guestbook $guestbook) {
        $guestbookAdmin = $guestbook->user()->first();
        if(UserBanHelper::isBanned($guestbookAdmin)) {
            return view('guestbooks.adminIsBanned');
        }

        $entries = $guestbook->entries()
            ->where('approved', true)
            ->latest()
            ->get();
        
        return view('entries.index', ['entries' => $entries, 'guestbook' => $guestbook, 'is_embed' => true]);
    }

    public function create(Guestbook $guestbook)
    {
        return view('embed.guestbook', compact('guestbook'));
    }

    public function store(Request $request, Guestbook $guestbook)
    {
        $rules = [
            'name' => 'required|max:255',
            'comment' => 'required|max:20000',
            'website' => 'nullable|url',
            'captcha_type' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails() || !self::captcha_verify($request, $request->input('captcha_type'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid captcha. Please try again.',
            ], 422);
        }

        $entry = $guestbook->entries()->create([
            'name' => $request->input('name'),
            'comment' => $request->input('comment'),
            'website' => $request->input('website'),
            'approved' => !$guestbook->requires_approval,
        ]);

        return redirect()
            ->route('entries.index', ["guestbook" => $guestbook])->with('success','Entry created sucessfully');
    }

    private static function captcha_verify($request, $type) {
        if($type === 'image') {
            return self::captcha_verify_img($request);
        }
        if($type === 'audio') {
            return self::captcha_verify_audio($request);
        }

        return false;
    }

    private static function captcha_verify_img($request) {
        $rules = [
            'captcha' => 'required|captcha_api:' . $request->input('key') . ',default',
        ];
        $validator = Validator::make($request->all(), $rules);
        return !$validator->fails();
    }


    private static function captcha_verify_audio($request) {
        $captcha = $request->input('captcha');
        $key = $request->input('key');
        return AudioCaptcha::validate($key, $captcha);
    }
}
