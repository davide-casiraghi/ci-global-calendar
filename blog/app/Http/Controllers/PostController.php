<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;

use App\Classes\AccordionClass;
use App\Classes\GalleryClass;
use App\Classes\CardClass;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(5);

        return view('posts.index',compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    // **********************************************************************

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        //dump($categories);

        //return view('posts.create');
        //return view('posts.create')->with('categories', Category::all()->pluck('name', 'id'));
        return view('posts.create')->with('categories', $categories);
    }

    // **********************************************************************

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
            'body' => 'required',
        ]);

        /*Post::create($request->all());*/

        $post = new Post();
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        /*$post->author_id = auth()->id();*/
        $post->author_id = 0;
        $post->slug = $request->get('slug');
        $post->category_id = $request->get('category_id');

        $post->meta_description = $request->get('meta_description');
        $post->meta_keywords = $request->get('meta_keywords');
        $post->seo_title = $request->get('seo_title');
        $post->image = $request->get('image');
        $post->status = $request->get('status');
        $post->featured = $request->get('featured');

        $post->save();

        return redirect()->route('posts.index')
                        ->with('success','Post created successfully.');
    }

    // **********************************************************************

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // Accordion
            $accordionClass = new AccordionClass();
            $post->body = $accordionClass->getAccordion($post->body);
            //dump($post->body);

        // Card
            $cardClass = new CardClass();
            $post->body = $cardClass->getCard($post->body);

        // Gallery
            $storagePath = storage_path('app/public');
            $publicPath = public_path();
            //dump($storagePath,$publicPath);
            $galleryClass = new GalleryClass();
            //dump($post->body);
            $post->body = $galleryClass->getGallery($post->body, $storagePath, $publicPath);
            //dump($post->body);

        return view('posts.show',compact('post'));
    }

    // **********************************************************************

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit',compact('post'));
    }

    // **********************************************************************

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')
                        ->with('success','Post updated successfully');
    }

    // **********************************************************************

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')
                        ->with('success','Post deleted successfully');
    }

    // **********************************************************************

    /**
     * Return the single post datas by post id [title, body, image]
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
     public function postdata($post_id){
         $ret = DB::table('posts')->where('id', $post_id)->first();
         //dump($ret); 

         return $ret;
     }




    /**
     * Return the post HTML by SLUG.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
/*
    public function postdata($slug){
        $post = Post::where('slug', $slug)->first();

        // Accordion
            $accordionClass = new AccordionClass();
            $post->body = $accordionClass->getAccordion($post->body);
            //dump($post->body);

        // Card
            $cardClass = new CardClass();
            $post->body = $cardClass->getCard($post->body);

        // Gallery
            $storagePath = storage_path('app/public');
            $publicPath = public_path();
            //dump($storagePath,$publicPath);
            $galleryClass = new GalleryClass();
            //dump($post->body);
            $post->body = $galleryClass->getGallery($post->body, $storagePath, $publicPath);
            //dump($post->body);


        //return print_r($post);
        return view('post', array('post' => $post));
    }
    */

}
