<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\EditRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Requests\Post\DeleteRequest;
use App\Models\Post;
use App\Models\Images;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class PostController extends Controller
{
    public function __construct(ImageService $image)
    {
        $this->image = $image;
        view()->share('page', 'post');
    }
    
    public function store()
    {
        $posts = Post::all();
        return view('post.store', compact('posts'));
    }

    public function view($id)
    {
        $post = Post::with(['user', 'category', 'image'])->findOrFail($id);
        return view('post.view', compact('post'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('post.create', compact('categories'));
    }

    public function save(CreateRequest $request)
    {
        $file = $request->img;
        $post = $request->except(['_token', 'img']);
        $postId = Post::insertGetId($post);

        $this->image->setModelId($postId);
        $this->image->setModelType(Post::class);
        $this->image->upload($file);

        setActionResponse('success', __('messages.post.added'));
        return redirect()->route('post.store');
    }

    public function edit(EditRequest $request, $id)
    {
        $post = Post::with(['user', 'category', 'image'])->findOrFail($id);
        $categories = Category::all();
        return view('post.edit', compact(['post', 'categories']));
    }

    public function update(UpdateRequest $request, $id)
    {
        $updatedPost = $request->except(['_token', 'img']); 
        $post = Post::where('title', $request->title)->firstOrFail();
        
        if($post->isNotSelf($id)) {
            return redirect()->back()->withInput()
                ->withErrors(['title' => __('messages.post.exists')]);
        }

        $post = Post::find($id);

        if($request->file('img')) {
            $file = $request->file('img');

            $this->image->setModelId($postId);
            $this->image->setModelType(Post::class);
            $this->image->upload($file);

            $this->image->delete($post->image->name);
            $this->image->updateFileInfo($post->image);
            
            $post->update($updatedPost);
        } else {
            $post->update($updatedPost);
        }

        setActionResponse('success', __('messages.post.updated'));
        return redirect()->route('post.store');
    }

    public function delete(DeleteRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $image = $post->image;
    
        $this->image->delete($image);
        $post->delete();

        setActionResponse('success', __('messages.post.deleted'));
        return redirect()->route('post.store');
    }
}