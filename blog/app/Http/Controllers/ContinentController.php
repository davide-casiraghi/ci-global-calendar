<?php

namespace App\Http\Controllers;

use App\Continent;
use Illuminate\Http\Request;

class ContinentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $continents = Continent::latest()->paginate(5);

        return view('continents.index',compact('continents'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('continents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        request()->validate([
            'name' => 'required',
            'code' => 'required'
        ]);

        $continent = new Continent();
        $continent->name = $request->get('name');
        $continent->code = $request->get('code');

        $continent->save();

        return redirect()->route('continents.index')
                        ->with('success','Continent created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Continent  $continent
     * @return \Illuminate\Http\Response
     */
    public function show(Continent $continent){
        return view('continents.show',compact('continent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Continent  $continent
     * @return \Illuminate\Http\Response
     */
    public function edit(Continent $continent){
        return view('continents.edit',compact('continent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Continent  $continent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Continent $continent){
        request()->validate([
            'name' => 'required',
            'code' => 'required'
        ]);

        $continent->update($request->all());

        return redirect()->route('continents.index')
                        ->with('success','Continent updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Continent  $continent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Continent $continent){
        $continent->delete();
        return redirect()->route('continents.index')
                        ->with('success','Continent deleted successfully');
    }
}
