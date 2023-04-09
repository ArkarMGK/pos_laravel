<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct category list page
    public function list()
    {
        $categories = Category::when(request('key'), function ($query) {
            $query->where('name', 'LIKE', '%' . request('key') . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(5);
        $categories->appends(request()->all());
        return view('admin.category.list', compact('categories'));
    }

    // direct category create page
    public function createPage()
    {
        return view('admin.category.create');
    }

    // create category
    public function store(Request $request)
    {
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()
            ->route('category#list')
            ->with(['message' => 'Category Created Successfully']);
    }

    // delete category
    public function delete($id)
    {
        Category::where('id', $id)->delete();
        return back()->with(['message' => 'Category Deleted Successfully']);
    }

    // edit category
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    // update category
    public function update(Request $request)
    {
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::where('id', $request->id)->update($data);
        return redirect()
            ->route('category#list')
            ->with(['message' => 'Category Updated Successfully']);
    }
    // category validation check
    private function categoryValidationCheck($request)
    {
        Validator::make(
            $request->all(),
            [
                'categoryName' => 'required|min:4|unique:categories,name,'.$request->id,
            ],
            [
                'categoryName.required' => 'Please Fill A category Name',
                'categoryName.unique' =>
                    'Category Already Exist! Plase fill something new...',
            ]
        )->validate();
    }

    // request category Data
    private function requestCategoryData($request)
    {
        return [
            'name' => $request->categoryName,
        ];
    }
}
