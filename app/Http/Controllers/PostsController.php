<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Http\Requests\Posts\CreateRequest;
use App\Http\Requests\Posts\EditRequest;
use App\Http\Requests\Posts\UpdateRequest;
use App\Http\Requests\Posts\DeleteRequest;
use App\Models\Posts;
use App\Models\Images;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class PostsController extends Controller
{
    public function __construct(ImageService $image)
    {
        $this->image = $image;
    }
    
    public function store()
    {
        $posts = Posts::all();
        return view('posts.store', compact('posts'));
    }

    public function view($id)
    {
        $post = Posts::with(['user', 'category', 'image'])->find($id);
        return view('posts.view', compact('post'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('posts.create', compact('categories'));
    }

    public function save(Request $request)
    {
        $file = $request->img;
        $post = $request->except(['_token', 'img']);
        $postId = Posts::insertGetId($post);

        $this->image->upload($file, [
            'modelId' => $postId, 'modelType' => Posts::class
        ]);

        setActionResponse('success', __('messages.post.added'));
        return redirect()->route('posts.store');
    }

    public function edit(EditRequest $request, $id)
    {
        $post = Posts::with(['user', 'category', 'image'])->find($id);
        $categories = Categories::all();

        return view('posts.edit', compact(['post', 'categories']));
    }

    public function update(UpdateRequest $request, $id)
    {
        $updatedPost = $request->except(['_token', 'img']); 
        $post = Posts::where('title', $request->title)->first();
        
        if($post && $post->isNotSelf($id)) {
            return redirect()->back()->withInput()
                ->withErrors(['title' => __('messages.post.exists')]);
        }

        $post = Posts::find($id);

        if($request->file('img')) {
            $file = $request->file('img');

            $this->image->upload($file, [
                'modelId' => $id, 'modelType' => Posts::class
            ]);

            $oldImage = $post->image;
            $this->image->delete($oldImage->name);
            $this->image->updateInfo($oldImage);
            
            $post->update($updatedPost);
        } else {
            $post->update($updatedPost);
        }

        setActionResponse('success', __('messages.post.updated'));
        return redirect()->route('posts.store');
    }

    public function delete(DeleteRequest $request, $id)
    {
        $post = Posts::find($id);
        $image = $post->image;
    
        $this->image->delete($image->name);
        $post->delete();

        setActionResponse('success', __('messages.post.deleted'));
        return redirect()->route('posts.store');
    }
}