<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('category_access');

        $categories = Category::paginate();
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->authorize('category_create');

        $path = $request->file('img')->store('categories');
        $category = Category::create([
            'name_ar' =>$request->name_ar,
            'name_en' =>$request->name_en,
            'img' => $path,
        ]);

        if($category)
        {
            $data = [
                'msg' => __('category.Add Success'),
            ];
            return response()->json($data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorize('category_edit');

        // update img if exists
        $image = $category->img;
        if ($request->hasFile('img'))
        {
            Storage::delete($image);
            $image = Storage::putFile('categories', $request->file('img'));
        }
        // update category
        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'img' => $image,
        ]);

        if($category)
        {
            $data = [
                'msg' => __('category.Edit Success'),
            ];
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('category_delete');

        Storage::delete($category->img);
        $category->delete();

        $data = [
            'msg' => __('category.Delete Success'),
        ];
        return response()->json($data);
    }
}
