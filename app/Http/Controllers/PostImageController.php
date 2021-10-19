<?php

namespace App\Http\Controllers;

use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostImageController extends Controller
{
    public function destroy($id)
    {
        $image = PostImage::findOrFail($id);
        Storage::delete($image->image);
        $image->delete();
        return response()->json(__('Image Deleted Successfully'));
    }
}
