<?php
namespace App\Repositories;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;
use App\Repositories\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function getAll()
    {
        return Post::with('category', 'images')->paginate();
    }

    public function createPost($request)
    {
        $post = Post::create($request->all());

        foreach ($request->images  as $image) {
                $path = $image->store('posts');
                PostImage::create([
                    'image' => $path,
                    'post_id' => $post->id,
                ]);
            }
            //sync
    }

    public function updatePost($request, $id)
    {
      $post = Post::findOrFail($id);
      $post->update($request->all());
      if($request->images)
      {
        foreach ($request->images  as $image) {
            $path = $image->store('posts');
            PostImage::create([
                'image' => $path,
                'post_id' => $post->id,
            ]);
        }   
      }
    }

    public function deletePost($id)
    {
      $post = Post::findOrFail($id);
      //delete images
       $images = $post->images;
       foreach ($images as $image) {
          Storage::delete($image->image);
       }
       $post->delete();
    }
}