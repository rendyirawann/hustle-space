<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class PhotoboothController extends Controller
{
    public function checkCapture(Request $request)
    {
        // 1. Jika mode = 'pro' dan user auth = izinkan.
        if ($request->input('mode') === 'pro' && auth()->check()) {
            return response()->json(['allowed' => true]);
        }

        // 2. Mode demo (guest), limit by IP
        $ip = $request->ip();
        $date = now()->format('Y-m-d');
        $cacheKey = "photobooth_captures_{$ip}_{$date}";

        $captures = Cache::get($cacheKey, 0);

        if ($captures >= 3) {
            return response()->json([
                'allowed' => false,
                'message' => 'Anda telah mencapai batas 3x foto hari ini. Silakan berlangganan untuk tanpa batas!'
            ], 429);
        }

        // Increment usage
        Cache::put($cacheKey, $captures + 1, now()->endOfDay());

        return response()->json(['allowed' => true, 'remaining' => 2 - $captures]);
    }

    public function checkDownload(Request $request)
    {
        // 1. Jika mode = 'pro' dan user auth = izinkan.
        if ($request->input('mode') === 'pro' && auth()->check()) {
            return response()->json(['allowed' => true]);
        }

        // 2. Mode demo (guest), limit by IP
        $ip = $request->ip();
        $date = now()->format('Y-m-d');
        $cacheKey = "photobooth_downloads_{$ip}_{$date}";

        $downloads = Cache::get($cacheKey, 0);

        if ($downloads >= 1) {
            return response()->json([
                'allowed' => false,
                'message' => 'Anda telah mencapai batas 1x download hari ini. Silakan berlangganan!'
            ], 429);
        }

        // Increment usage
        Cache::put($cacheKey, $downloads + 1, now()->endOfDay());

        return response()->json(['allowed' => true]);
    }
}
