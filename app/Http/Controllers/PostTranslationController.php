<?php

namespace App\Http\Controllers;

use App\PostTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class PostTranslationController extends Controller
{
    /***************************************************************************/
    /* Restrict the access to this resource just to logged in users */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     * @param int $postId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function create($postId, $languageCode)
    {
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('postTranslations.create')
                ->with('postId', $postId)
                ->with('languageCode', $languageCode)
                ->with('selectedLocaleName', $selectedLocaleName);
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $postId
     * @param string $languageCode
     * @return \Illuminate\Http\Response
     */
    public function edit($postId, $languageCode)
    {
        $postTranslation = PostTranslation::where('post_id', $postId)
                        ->where('locale', $languageCode)
                        ->first();

        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('postTranslations.edit', compact('postTranslation'))
                    ->with('postId', $postId)
                    ->with('languageCode', $languageCode)
                    ->with('selectedLocaleName', $selectedLocaleName);
    }

    /***************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validate form datas
        $validator = Validator::make($request->all(), [
                'title' => 'required',
                'body' => 'required',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $postTranslation = new PostTranslation();

        $postTranslation->post_id = $request->get('post_id');
        $postTranslation->locale = $request->get('language_code');

        $postTranslation->title = $request->get('title');
        //$postTranslation->body = $request->get('body');
        $postTranslation->body = clean($request->get('body'));
        $postTranslation->slug = Str::slug($postTranslation->title, '-');

        $postTranslation->before_content = $request->get('before_content');
        $postTranslation->after_content = $request->get('after_content');

        $postTranslation->save();

        return redirect()->route('posts.index')
                        ->with('success', 'Translation created successfully.');
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $postTranslation = PostTranslation::where('id', $request->get('post_translation_id'));

        $pt = [];
        $pt['title'] = $request->get('title');
        $pt['body'] = clean($request->get('body'));
        $pt['slug'] = Str::slug($request->get('title'), '-');
        $pt['before_content'] = $request->get('before_content');
        $pt['after_content'] = $request->get('after_content');

        $postTranslation->update($pt);

        return redirect()->route('posts.index')
                        ->with('success', 'Post updated successfully');
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $postTranslationId
     * @return \Illuminate\Http\Response
     */
    public function destroy($postTranslationId)
    {
        $postTranslation = PostTranslation::find($postTranslationId);
        $postTranslation->delete();

        return redirect()->route('posts.index')
                        ->with('success', __('messages.post_translation_deleted_successfully'));
    }
}
