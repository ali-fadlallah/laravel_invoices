<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Sections::all();

        return view('sections.sections', compact('sections'));

        //
        // return view('sections.sections');
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

        $request->validate([

            'section_name' => 'required|string|max:255|unique:sections,section_name',
        ], [
                'section_name.required' => 'اجباري',
                'section_name.unique' => 'مسجل من قبل'

            ]);

        Sections::create([

            'section_name' => $request->section_name,
            'description' => $request->section_desc,
            'created_by' => Auth::user()->name,

        ]);

        return redirect()->route('section_index')->with("success", $request->section_name . " has been added successfflly");


    }

    /**
     * Display the specified resource.
     */
    public function show(Sections $sections)
    {
        //
        $sections = Sections::all();

        return view('section_index', compact('sections'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $checkSection = Sections::findOrFail($request->id);

        $data = $request->validate([

            'section_name' => 'required|string|max:255|unique:sections,section_name',
            'description' => 'string',
        ]);

        $checkSection->update($data);

        return redirect()->route('section_index')->with("success", $data['section_name'] . " has been updated successfflly");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $checkSection = Sections::findOrFail($request->id);

        $checkSection->delete();

        return redirect()->route('section_index')->with("success", $request->section_name . " has been deleted successfflly");
    }
}