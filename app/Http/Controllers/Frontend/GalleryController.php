<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PublishedPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        // Get all published photos, latest first
        $photos = PublishedPhoto::latest()->get();
        return view('gallery', compact('photos'));
    }

    public function publish(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $ip = $request->ip();
        $isPro = auth()->check() && $request->input('mode') === 'pro';

        if ($isPro) {
            // Pro limit: 1 per week
            $recent = PublishedPhoto::where('user_id', auth()->id())
                ->where('created_at', '>=', now()->subWeek())
                ->exists();
                
            if ($recent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Limit Pro: Anda hanya dapat mempublish foto 1 kali dalam seminggu.'
                ], 429);
            }
        } else {
            // Guest limit: 1 per month
            $recent = PublishedPhoto::where('ip_address', $ip)
                ->whereNull('user_id')
                ->where('created_at', '>=', now()->subMonth())
                ->exists();
                
            if ($recent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Limit Guest: Anda hanya dapat mempublish foto 1 kali dalam sebulan. Silakan berlangganan Pro!'
                ], 429);
            }
        }

        // Decode and save the image
        $base64Image = $request->input('image');
        list($type, $data) = explode(';', $base64Image);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        $filename = 'published_photos/' . Str::uuid() . '.png';
        Storage::disk('public')->put($filename, $data);

        // Save to DB
        PublishedPhoto::create([
            'user_id' => $isPro ? auth()->id() : null,
            'image_path' => $filename,
            'ip_address' => $ip,
        ]);

        return response()->json(['success' => true]);
    }
}
