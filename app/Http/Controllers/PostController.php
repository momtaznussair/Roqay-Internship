<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Repositories\PostRepositoryInterface;

class PostController extends Controller
{
    private $PostRepo;
    public function __construct(PostRepositoryInterface $PostRepo)
    {
        $this->PostRepo = $PostRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->PostRepo->getAll();
        $categories = Category::all();
        return view('posts.index', compact('posts', 'categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->PostRepo->createPost($request);
        return response()->json(__('Post Created Successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $this->PostRepo->updatePost($request, $id);
        return response()->json(__('Changes Saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->PostRepo->deletePost($id);
        return response()->json(__('Post Deleted Successfully'));
        
    }
}
