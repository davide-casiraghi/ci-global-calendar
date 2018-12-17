<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;

use App\Classes\AccordionClass;
use App\Classes\GalleryClass;
use App\Classes\CardClass;
use App\Classes\ColumnsClass;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PostController extends Controller
{
    /***************************************************************************/
    /**
     * Constructor
     *
     * @return none
     */
    public function __construct(){
        
        //Restrict the access to this resource just to logged in users except show view 
            $this->middleware('auth', ['except' => ['show']]);
    }
    
    /***************************************************************************/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $categories = Category::pluck('name', 'id');

        $searchKeywords = $request->input('keywords');
        $searchCategory = $request->input('category_id');

        // Get current locale
            //dd(App::getLocale());

        // Returns all countries having translations
            //dd(Post::translated()->get());
        // Countries available for translations
            $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        if ($searchKeywords||$searchCategory){
            $posts = Post::
                when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('title', $searchKeywords)->orWhere('title', 'like', '%' . $searchKeywords . '%');
                })
                ->when($searchCategory, function ($query, $searchCategory) {
                    return $query->where('category_id', '=', $searchCategory);
                })
                ->paginate(20);
        }
        else
            $posts = Post::latest()->paginate(20);

        return view('posts.index',compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 20)->with('categories',$categories)->with('searchKeywords',$searchKeywords)->with('searchCategory',$searchCategory)->with('countriesAvailableForTranslations',$countriesAvailableForTranslations);
    }

    /***************************************************************************/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $categories = Category::pluck('name', 'id');
        //dump($categories);

        //return view('posts.create');
        return view('posts.create')->with('categories', $categories);
    }

    /***************************************************************************/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $post = new Post();
        
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        
        $this->saveOnDb($request, $post);    

        return redirect()->route('posts.index')
                        ->with('success','Post created successfully.');
    }

    /***************************************************************************/
    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post){

        // Accordion
            $accordionClass = new AccordionClass();
            $post->body = $accordionClass->getAccordion($post->body);
            $post->before_content = $accordionClass->getAccordion($post->before_content);
            $post->after_content = $accordionClass->getAccordion($post->after_content);

        // Card
            $cardClass = new CardClass();
            $post->body = $cardClass->getCard($post->body);
            $post->before_content = $cardClass->getCard($post->before_content);
            $post->after_content = $cardClass->getCard($post->after_content);

        // Category Columns
            $columnClass = new ColumnsClass();
            $post->body = $columnClass->getColumns($post->body);
            $post->before_content = $columnClass->getColumns($post->before_content);
            $post->after_content = $columnClass->getColumns($post->after_content);

        // Gallery
            $storagePath = storage_path('app/public');
            $publicPath = public_path();
            //dump($storagePath,$publicPath);
            $galleryClass = new GalleryClass();
            //dump($post->body);
            $post->body = $galleryClass->getGallery($post->body, $storagePath, $publicPath);
            $post->before_content = $galleryClass->getGallery($post->before_content, $storagePath, $publicPath);
            $post->after_content = $galleryClass->getGallery($post->after_content, $storagePath, $publicPath);

        return view('posts.show',compact('post'));
    }

    /***************************************************************************/
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post){

        $categories = Category::pluck('name', 'id');

        return view('posts.edit',compact('post'))->with('categories', $categories);
    }

    /***************************************************************************/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post){

        request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        //$post->update($request->all());
        $this->saveOnDb($request, $post);

        return redirect()->route('posts.index')
                        ->with('success','Post updated successfully');
    }

    /***************************************************************************/
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post){
        $post->delete();
        return redirect()->route('posts.index')
                        ->with('success','Post deleted successfully');
    }

    /***************************************************************************/
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

     /***************************************************************************/
     /**
      * Return all the posts from by category id
      *
      * @param  \App\Post  $post
      * @return \Illuminate\Http\Response
      */
      public function postsdata($cat_id){
          $ret = DB::table('posts')->where('category_id', $cat_id)->get();

          return $ret;
      }

    /***************************************************************************/
    /**
     * Return the post HTML by SLUG. (eg. http://laravelblog.fr/post/davide_spada)
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */

    public function postBySlug($slug){
        $post = Post::where('slug', $slug)->first();
        return $this->show($post);
    }

    /***************************************************************************/
    /**
     * Save the record on DB
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
     public function saveOnDb($request, $post){
         
         $post->title = $request->get('title');
         $post->body = $request->get('body');
         $post->created_by = \Auth::user()->id;
         $post->slug = str_slug($post->title, '-').rand(100000, 1000000);
         $post->category_id = $request->get('category_id');
         
         $post->status = $request->get('status');
         $post->featured = $request->get('featured');
         
         // Intro image  picture upload
         if ($request->file('introimage')){
             $introImagePictureFile = $request->file('introimage');
             $imageName = $introImagePictureFile->hashName();
             $path = $introImagePictureFile->store('public/images/posts_intro_images');
             $post->introimage = $imageName;
        }

         $post->before_content = $request->get('before_content');
         $post->after_content = $request->get('after_content');
         
         $post->save();
         
     }
}
