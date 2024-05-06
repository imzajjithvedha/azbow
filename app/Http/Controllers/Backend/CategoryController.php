<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if(session('categories')) {
            $categories = session('categories');
            $name = session('name');
            $items = 10;

            session()->forget('categories');
            session()->forget('name');
        }
        else {
            $items = $request->items ?? 10;
            $categories = Category::where('status', '!=', '0')->paginate($items);
            $name = null;
        }

        foreach($categories as $category) {
            $category->action = '
            <a id="'.$category->id.'" class="view btn btn-success btn-sm mx-1 rounded-0" title="View"><i class="bi bi-back"></i></a>
            <a id="'.$category->id.'" class="edit btn btn-warning btn-sm mx-1 rounded-0" title="Edit"><i class="bi bi-pencil-fill"></i></a>
            <a id="'.$category->id.'" class="delete btn btn-danger btn-sm mx-1 rounded-0" title="Delete"><i class="bi bi-trash"></i></a>';

            $category->status = ($category->status == '1') ? '<span class="badge text-bg-success">Activate</span>' : '<span class="badge text-bg-danger">Deactivate</span>';
        }

        return view('backend.categories', [
            'categories' => $categories,
            'name' => $name,
            'items' => $items
        ]);
    }
                                                                              
    public function store(Request $request)
    {
        $category = new Category();
        $data = $request->all();
        $category->create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Successfully created!');
    }

    public function show(Category $category)
    {
        return response($category);
    }

    public function edit(Category $category)
    {
        return response($category);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->all();
        $category->fill($data)->save();
        
        return redirect()->route('admin.categories.index')->with('success', "Successfully updated!");
    }

    public function destroy(Category $category)
    {
        $category->status = '0';
        $category->save();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }

    public function filter(Request $request)
    {
        if($request->has('reset')) {
            $filter_keys = ['categories', 'name'];
            foreach($filter_keys as $key) {
                session([$key => null]);
            }

            return redirect()->route('admin.categories.index');
        }

        $name = $request->name;

        $categories = Category::where('status', '!=', '0');

        if($name != null) {
            $categories->where('name', 'like', '%' . $name . '%');
        }

        $categories = $categories->orderBy('id', 'asc')->paginate(10);

        session([
            'categories' => $categories,
            'name' => $name,
        ]);

        return redirect()->route('admin.categories.index');
    }
}
