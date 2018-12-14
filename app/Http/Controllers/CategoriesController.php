<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Http\Requests\Categories\UpdateRequest;
use App\Http\Requests\Categories\CreateRequest;

class CategoriesController extends Controller
{
    public function store()
    {
        $categories = Categories::orderBy('id', 'desc')->get();
        return view('categories.store', compact('categories'));
    }

    public function save(CreateRequest $request)
    {
        Categories::create($request->all());
        setActionResponse('success', 'The category has been successfully added!');
        return redirect()->route('categories.store');
    }

    public function update(UpdateRequest $request, $id)
    {
        $name = $request->input('name_'.$id);
        $category = Categories::where('name', $name)->first();

        if($category && $category->id != $id) {
            session()->flash('name_'.$id,
                'The category with this name already exists. Choose another one.'
            );

            return redirect()->back()->withInput();
        }

        Categories::find($id)->update([
            'name' => $request->input('name_'.$id)
        ]);

        setActionResponse('success', 'The category has been successfully updated!');
        return redirect()->route('categories.store');
    }

    public function delete($id)
    {
        Categories::find($id)->delete();
        setActionResponse('success', 'The category has been successfully deleted!');
        return redirect()->route('categories.store');
    }
}
