<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function list()
    {
        $products = Product::select(
            'products.*',
            'categories.name as category_name'
        )
            ->when(request('key'), function ($query) {
                $query->where(
                    'products.name',
                    'like',
                    '%' . request('key') . '%'
                );
            })
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->latest()
            ->paginate(2);
        // dd($products->toArray());
        return view('admin.products.list', compact('products'));
    }

    // Category Create Page
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Show product info
    public function show($id)
    {
        $product = Product::select(
            'products.*',
            'categories.name as category_name'
        )
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id',$id)
            ->first();
        return view('admin.products.show', compact('product'));
    }

    // Edit Product Info Page
    public function edit($id)
    {
        $categories = Category::get();
        $product = Product::where('id', $id)->first();
        return view('admin.products.edit', compact('categories', 'product'));
    }

    // Update Product Info
    public function update(Request $request)
    {
        $this->productValidationCheck($request, 'update');
        $data = $this->getProductInfo($request);
        if ($request->hasFile('image')) {
            $oldImage = Product::where('id', $request->id)->first();
            $oldImage = $oldImage->image;

            if ($oldImage != null) {
                Storage::delete('public/images/product/' . $oldImage);
            }
            $fileName =
                uniqid() . $request->file('image')->getClientOriginalName();
            $request
                ->file('image')
                ->storeAs('public/images/product/', $fileName);
            $data['image'] = $fileName;
        }

        Product::where('id', $request->id)->update($data);
        return redirect()
            ->route('product#list')
            ->with(['message' => 'Product Updated Successfully!..']);
    }

    //  Delete Product
    public function delete($id)
    {
        Product::where('id', $id)->delete();
        return redirect()
            ->route('product#list')
            ->with(['message' => 'Product Deleted Successfully! ']);
    }
    // Store a new Product in the database
    public function store(Request $request)
    {
        $this->productValidationCheck($request, 'create');
        $data = $this->getProductInfo($request);
        $fileName = uniqid() . $request->image->getClientOriginalName();
        $request->image->storeAs('public/images/product', $fileName);
        $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('product#list');
    }

    // product validation check
    private function productValidationCheck($request, $action)
    {
        $validationRules = [
            'name' => 'required | min:5| unique:products,name,' . $request->id,
            'category' => 'required',
            'description' => 'min:10',
            'price' => 'required',
        ];
        $validationRules['image'] =
            $action == 'create'
                ? 'required|mimes:png,jpg,jpeg|file'
                : 'mimes:png,jpg,jpeg|file';
        Validator::make($request->all(), $validationRules)->validate();
    }

    private function getProductInfo($request)
    {
        return [
            'name' => $request->name,
            'category_id' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
        ];
    }
}
