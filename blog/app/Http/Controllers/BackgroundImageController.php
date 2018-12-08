<?php

namespace App\Http\Controllers;

use App\BackgroundImage;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BackgroundImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchKeywords = $request->input('keywords');
        
        if ($searchKeywords){
            $backgroundImages = DB::table('background_images')
            ->when($searchKeywords, function ($query, $searchKeywords) {
                return $query->where('credits', $searchKeywords)->orWhere('credits', 'like', '%' . $searchKeywords . '%');
            })
            ->paginate(20);
        }
        else{
            $backgroundImages = BackgroundImage::latest()->paginate(20);
        }

        return view('backgroundImages.index',compact('backgroundImages'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('searchKeywords',$searchKeywords);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backgroundImages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'image_src' => 'required',
            'orientation' => 'required',
        ]);


        BackgroundImage::create($request->all());


        return redirect()->route('backgroundImages.index')
                        ->with('success','BackgroundImage created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BackgroundImage  $backgroundImage
     * @return \Illuminate\Http\Response
     */
    public function show(BackgroundImage $backgroundImage)
    {
        return view('backgroundImages.show',compact('backgroundImage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BackgroundImage  $backgroundImage
     * @return \Illuminate\Http\Response
     */
    public function edit(BackgroundImage $backgroundImage)
    {
        return view('backgroundImages.edit',compact('backgroundImage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BackgroundImage  $backgroundImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BackgroundImage $backgroundImage)
    {
        request()->validate([
            'title' => 'required',
            'image_src' => 'required',
            'orientation' => 'required',
        ]);

        $backgroundImage->update($request->all());

        return redirect()->route('backgroundImages.index')
                        ->with('success','Background image updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BackgroundImage  $backgroundImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(BackgroundImage $backgroundImage)
    {
        $backgroundImage->delete();

        return redirect()->route('backgroundImages.index')
                        ->with('success','Background image deleted successfully');
    }
}
