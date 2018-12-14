<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MyTestService;
use App\Models\Categories;
use App\Http\Requests\Posts\CreateRequest;
use App\Http\Requests\Posts\EditRequest;
use App\Http\Requests\Posts\UpdateRequest;
use App\Http\Requests\Posts\DeleteRequest;
use App\Models\Posts;
use App\Models\Images;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    public function store()
    {
        $posts = Posts::all();
        return view('posts.store', compact('posts'));
    }

    public function view($id)
    {
        $post = Posts::find($id);
        return view('posts.view', compact('post'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('posts.create', compact('categories'));
    }

    public function save(CreateRequest $request)
    {
        $post = $request->except(['_token', 'img']);

        $img = $request->file('img');
        $extension = $img->getClientOriginalExtension();
        $imgName = 'img_'.time().'.'.$extension;
        $img->storeAs('public/images', $imgName);
        
        $postId = Posts::insertGetId($post);

        Images::create([
            'name' => $imgName,
            'mime' =>$img->getClientMimeType(),
            'imageable_id' => $postId,
            'imageable_type' => Posts::class
        ]);

        setActionResponse('success', 'The post has been successully added!');
        return redirect()->route('posts.store');
    }

    public function edit(EditRequest $request, $id)
    {
        $post = Posts::find($id);
        $categories = Categories::all();
        return view('posts.edit', compact(['post', 'categories']));
    }

    public function update(UpdateRequest $request, $id)
    {
        $updatedPost = $request->except(['_token', 'img']); 
        $post = Posts::where('title', $request->title)->first();
        
        if($post && $id != $post->id) {
            session()->flash('title',
                'The post with this title already exists! 
                 The title must be unique. Choose another one.'
            );
            
            return redirect()->back()->withInput();
        }

        $post = Posts::find($id);

        if($request->file('img')) {
            $img = $request->file('img');
            $extension = $img->getClientOriginalExtension();
            $imgName = 'img_'.time().'.'.$extension;
            $img->storeAs('public/images', $imgName);

            $oldImage = $post->image;

            if(Storage::exists('public/images/'.$oldImage->name)) {
                Storage::delete('public/images/'.$oldImage->name);
            }

            $oldImage->update([
                'name' => $imgName,
                'mime' => $img->getClientMimeType(),
                'imageable_id' => $id,
                'imageable_type' => Posts::class
            ]);
            
            $post->update($updatedPost);
        } else {
            $post->update($updatedPost);
        }

        setActionResponse('success', 'The post has been successully updated!');
        return redirect()->route('posts.store');
    }

    public function delete(DeleteRequest $request, $id)
    {
        $post = Posts::find($id);
        $image = $post->image;
        
        if(Storage::exists('public/images/'.$image->name)) {
            Storage::delete('public/images/'.$image->name);
        }

        $post->delete();
        $image->delete();

        setActionResponse('success', 'The post has been successully deleted!');
        return redirect()->route('posts.store');
    }
}