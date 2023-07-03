<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sections = Sections::all();
        $products = Products::all();
        return view('products.products', compact('sections', 'products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $data = $request->validate([

            'product_name' => 'required|string|max:255|unique:sections,section_name',
            'section_id' => 'required|not_in:0',
            'description' => 'required'
        ]);

        Products::create($data);

        return redirect()->route('product_index')->with("success", $request->product_name . " has been added successfflly");
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $checkProduct = Products::findOrFail($request->id);

        $section_id = Sections::where('section_name', '=', $request->section_name)->first()->id;

        $data = $request->validate([

            'product_name' => 'required|string|max:255',
            'section_id' => 'integer|exists:sections,section_id',
            'description' => 'string',
        ]);

        $data['section_id'] = $section_id;

        $checkProduct->update($data);

        return redirect()->route('product_index')->with("success", $data['product_name'] . " has been updated successfflly");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $checkProduct = Products::findOrFail($request->id);

        $checkProduct->delete();

        return redirect()->route('product_index')->with("success", $request->product_name . " has been deleted successfflly");
    }
}