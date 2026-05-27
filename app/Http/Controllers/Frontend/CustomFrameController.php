<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomFrame;
use Illuminate\Support\Facades\Storage;

class CustomFrameController extends Controller
{
    // Return editor view
    public function index()
    {
        $userId = auth()->id();
        $frames = CustomFrame::where('user_id', $userId)->get();
        return view('hustle-posed-frame-creation', compact('frames'));
    }

    // Upload decoration image
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png|max:256', // max 256 KB
        ]);

        $userId = auth()->id();
        $file = $request->file('image');
        
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("public/frame_creation/{$userId}", $filename);

        return response()->json([
            'url' => Storage::url($path),
            'path' => $path
        ]);
    }

    // Save custom frame
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'layout' => 'required|in:1,2,4',
            'base_theme' => 'required|string',
            'decorations' => 'nullable|array',
        ]);

        $userId = auth()->id();

        // Check limit
        $count = CustomFrame::where('user_id', $userId)->count();
        if ($count >= 3) {
            return response()->json(['success' => false, 'message' => 'Maksimal 3 custom frame diperbolehkan. Hapus frame lain untuk membuat yang baru.'], 403);
        }

        $frame = CustomFrame::create([
            'user_id' => $userId,
            'name' => $request->name,
            'layout' => $request->layout,
            'base_theme' => $request->base_theme,
            'decorations' => $request->decorations,
            'is_public' => false
        ]);

        return response()->json(['success' => true, 'frame' => $frame]);
    }

    // Delete custom frame
    public function destroy($id)
    {
        $userId = auth()->id();
        $frame = CustomFrame::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $frame->delete();
        
        // We don't necessarily delete the uploaded files to keep it simple, 
        // or we could parse decorations and delete them.
        
        return response()->json(['success' => true]);
    }

    // Toggle publish
    public function togglePublish($id)
    {
        $userId = auth()->id();
        $frame = CustomFrame::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $frame->is_public = !$frame->is_public;
        $frame->save();

        return response()->json(['success' => true, 'is_public' => $frame->is_public]);
    }

    // Get frames for photobooth
    public function getList(Request $request)
    {
        $mode = $request->query('mode', 'demo');
        $userId = auth()->id();

        if ($mode === 'pro' && $userId) {
            // Get user's own frames + public frames from others
            $frames = CustomFrame::where('user_id', $userId)
                        ->orWhere('is_public', true)
                        ->with('user:id,name') // Get creator name
                        ->get();
        } else {
            // Get only public frames
            $frames = CustomFrame::where('is_public', true)
                        ->with('user:id,name')
                        ->get();
        }

        return response()->json(['frames' => $frames]);
    }
}
