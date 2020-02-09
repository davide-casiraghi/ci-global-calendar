<?php

namespace App\Http\Controllers;

use App\BackgroundImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class BackgroundImageController extends Controller
{
    /* Restrict the access to this resource just to logged in users */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $searchKeywords = $request->input('keywords');
        $orientation = $request->input('orientation');

        if ($searchKeywords || $orientation) {
            $backgroundImages = DB::table('background_images')
            ->when($searchKeywords, function ($query, $searchKeywords) {
                return $query->where('credits', $searchKeywords)->orWhere('credits', 'like', '%'.$searchKeywords.'%');
            })
            ->when($orientation, function ($query, $orientation) {
                return $query->where('orientation', '=', $orientation);
            })
            ->paginate(20);
        } else {
            $backgroundImages = BackgroundImage::latest()->paginate(20);
        }

        return view('backgroundImages.index', compact('backgroundImages'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('searchKeywords', $searchKeywords)
            ->with('orientation', $orientation);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backgroundImages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // Validate form datas
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image_src' => 'required',
            'orientation' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        BackgroundImage::create($request->all());

        return redirect()->route('backgroundImages.index')
                        ->with('success', __('messages.background_image_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BackgroundImage  $backgroundImage
     * @return \Illuminate\View\View
     */
    public function show(BackgroundImage $backgroundImage)
    {
        return view('backgroundImages.show', compact('backgroundImage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BackgroundImage  $backgroundImage
     * @return \Illuminate\View\View
     */
    public function edit(BackgroundImage $backgroundImage)
    {
        return view('backgroundImages.edit', compact('backgroundImage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BackgroundImage  $backgroundImage
     * @return \Illuminate\Http\RedirectResponse
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
                        ->with('success', __('messages.background_image_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BackgroundImage  $backgroundImage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BackgroundImage $backgroundImage)
    {
        $backgroundImage->delete();

        return redirect()->route('backgroundImages.index')
                        ->with('success', __('messages.background_image_deleted_successfully'));
    }
}
