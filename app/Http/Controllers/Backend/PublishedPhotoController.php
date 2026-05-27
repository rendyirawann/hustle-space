<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PublishedPhoto;
use Illuminate\Support\Facades\Storage;

class PublishedPhotoController extends Controller
{
    public function index()
    {
        $photos = PublishedPhoto::with('user')->latest()->paginate(12);
        return view('backend.published-photos.index', compact('photos'));
    }

    public function destroy($id)
    {
        $photo = PublishedPhoto::findOrFail($id);
        
        // Delete image from storage
        if (Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }
        
        $photo->delete();
        
        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }
}
