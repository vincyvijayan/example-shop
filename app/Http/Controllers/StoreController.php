<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Category;
use App\Models\Product;

class StoreController extends Controller
{
    
    public function index(): View
    {

        $products = Product::with('category')->latest()->paginate(5);
    
        return view('onlinestore.add_product',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    } 
    
    public function create_category(): View
    {

        $categories = Category::all();

        return view('onlinestore.create_category',compact('categories'));
    } 

    public function storeCategory(Request $request) : RedirectResponse
    {

    	$request->validate([
            'name' => 'required',
           
        ]);
        
        Category::create($request->post());

        return redirect()->route('onlinestore.create-category')->withSuccess('Categoty has been created successfully.');
    }


    public function create()
    {

        $categories = Category::all();

        return view('onlinestore.create',compact('categories'));

    }


    public function store(Request $request) : RedirectResponse
    {

        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'color' => 'required',
            'size' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
           
        ]);

        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $productImage = date('YmdHis') . "." . 'webp';
            $image->move($destinationPath, $productImage);
            $request['image'] = $productImage;
        }else{
            unset($request['image']);
        }
     
        Product::create($request->post());

        return redirect()->route('ecommerce-manager')->withSuccess('Product has been created successfully.');
    }
    
    public function edit($request)
    {
       
        $product = Product::find($request);

        $categories = Category::all();
        
        return view('onlinestore.edit',compact('product','categories'));
    }

    public function update(Request $request,$id) : RedirectResponse
    {
        $product = Product::find($id);
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'color' => 'required',
            'size' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
  
        if ($image = $request->file('image')) {

            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . 'webp';
            $image->move($destinationPath, $profileImage);
            $request['image'] = "$profileImage";

        }else{
            unset($request['image']);
        }
          
        $product->update($request->post());

        return redirect()->route('ecommerce-manager')->withSuccess('Product updated successfully.');
    
    }


    public function destroy(Product $product,$id)
    {
       
        $product = Product::find($id)->delete();
     
        return redirect()->route('ecommerce-manager')
                        ->withSuccess('Product deleted successfully');
    }

}
