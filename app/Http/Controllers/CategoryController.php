<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Requests\Category\CreateRequest;

class CategoryController extends Controller
{
    public function store()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('category.store', compact('categories'));
    }

    public function save(CreateRequest $request)
    {
        Category::create($request->all());
        setActionResponse('success', __('messages.category.added'));
        return redirect()->route('category.store');
    }

    public function update(UpdateRequest $request, $id)
    {
        $name = $request->input('name_'.$id);
        $category = Category::where('name', $name)->first();

        if($category && $category->isNotSelf($id)) {
            return redirect()->back()->withInput()
                ->withErrors(['name_'.$id => __('messages.category.exists')]);
        }

        Category::find($id)->update([
            'name' => $request->input('name_'.$id)
        ]);

        setActionResponse('success', __('messages.category.updated'));
        return redirect()->route('category.store');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        setActionResponse('success', __('message.category.deleted'));
        return redirect()->route('category.store');
    }
}
