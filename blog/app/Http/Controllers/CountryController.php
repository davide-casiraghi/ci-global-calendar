<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $countries = Country::latest()->paginate(5);

        return view('countries.index',compact('countries'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('countries.create');
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
            'code' => 'required',
            'continent_id' => 'required'
        ]);

        $country = new Country();
        $country->name = $request->get('name');
        $country->code = $request->get('code');
        $country->continent_id = $request->get('continent_id');

        $country->save();

        return redirect()->route('countries.index')
                        ->with('success','Country created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country){
        return view('countries.show',compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country){
        return view('countries.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country){
        request()->validate([
            'name' => 'required',
            'code' => 'required',
            'continent_id' => 'required'
        ]);

        $country->update($request->all());

        return redirect()->route('countries.index')
                        ->with('success','Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country){
        $country->delete();
        return redirect()->route('countries.index')
                        ->with('success','Country deleted successfully');
    }
}
