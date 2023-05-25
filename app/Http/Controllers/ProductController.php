<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;



class ProductController extends Controller
{

    public function display(Request $request)
    {
        $products = product::latest()->paginate(5);
        return view('layouts.product.product', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sel1' => 'required',
            'price' => 'required'
        ]);

        product::create([
            'product_name' => $request->name,
            'unit' => $request->sel1,
            'price' => $request->price
        ]);

        return response()->json([
            'success' => 'Data Saved Successfully'], 201);
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sel1' => 'required',
            'price' => 'required'
        ]);

        product::where('id', $request->idno)->update([
            'product_name' => $request->name,
            'unit' => $request->sel1,
            'price' => $request->price
        ]);



        return response()->json([
            'success' => 'Data Update Successfully'], 201);
    }

    public function delete(Request $request)
    {
        //$post = product::where('id', $request->id)->firstOrFail();
        //$post->delete();
        product::find($request->iid)->delete();
        return response()->json(['success' => 'Data Delete Successfully'], 201);
    }

    public function paginate(Request $request)
    {
        $products = product::latest()->paginate(5);
        return view('layouts.product.product_pagi', compact('products'))->render();
    }

    public function search(Request $request)
    {
        $products = product::where("product_name", 'like', '%'.$request->txt.'%')
            ->orderby('id','desc')->paginate(5);
            if($products->count() >=1){
                return view('layouts.product.product_pagi', compact('products'))->render();
            } else {
                return response()->json([
                    'status' => 'Nothing Found'], 201);
            }
    }

}
