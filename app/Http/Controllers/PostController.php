<?php

namespace App\Http\Controllers;

use App\Post;
use Validator;
use App\Category;
use App\Classes\CardClass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Classes\ColumnsClass;
use App\Classes\GalleryClass;
use App\Classes\AccordionClass;
use App\Classes\StatsDonateClass;
use App\Classes\PaypalButtonClass;
use Illuminate\Support\Facades\DB;
use App\Classes\CardsCarouselClass;
use Illuminate\Support\Facades\App;
use App\Classes\CommunityGoalsClass;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PostController extends Controller
{
    /***************************************************************************/

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {

        //Restrict the access to this resource just to logged in users except show view
        $this->middleware('admin', ['except' => ['show', 'postBySlug']]);
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::getCategoriesArray();

        $searchKeywords = $request->input('keywords');
        $searchCategory = $request->input('category_id');

        // Returns all countries having translations
        //dd(Post::translated()->get());

        // Countries available for translations
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();
        //DB::enableQueryLog();

        if ($searchKeywords || $searchCategory) {
            $posts = Post::
                select('post_translations.post_id AS id', 'post_translations.title AS title', 'category_id', 'locale')
                ->join('post_translations', 'posts.id', '=', 'post_translations.post_id')

                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('post_translations.locale', '=', 'en')
                                 ->where(function ($query) use ($searchKeywords) {
                                     $query->where('post_translations.title', $searchKeywords)
                                                  ->orWhere('post_translations.title', 'like', '%'.$searchKeywords.'%');
                                 });
                })
                ->when($searchCategory, function ($query, $searchCategory) {
                    return $query->where('post_translations.locale', '=', 'en')
                                 ->where(function ($query) use ($searchCategory) {
                                     $query->where('category_id', '=', $searchCategory);
                                 });
                })
                ->paginate(20);
        } else {
            $posts = Post::select('id', 'title', 'category_id')->orderBy('title')->paginate(20);
        }

        //dd(DB::getQueryLog());

        //dd($posts);

        return view('posts.index', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('categories', $categories)
            ->with('searchKeywords', $searchKeywords)
            ->with('searchCategory', $searchCategory)
            ->with('countriesAvailableForTranslations', $countriesAvailableForTranslations);
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::getCategoriesArray();

        return view('posts.create')->with('categories', $categories);
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
                'category_id' => 'required',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $post = new Post();

        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
        App::setLocale('en');

        $this->saveOnDb($request, $post);

        return redirect()->route('posts.index')
                        ->with('success', __('messages.article_added_successfully'));
    }

    /***************************************************************************/

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
        $post->before_content = $accordionClass->getAccordion($post->before_content);
        $post->after_content = $accordionClass->getAccordion($post->after_content);

        // Card
        $cardClass = new CardClass();
        $post->body = $cardClass->getCard($post->body);
        $post->before_content = $cardClass->getCard($post->before_content);
        $post->after_content = $cardClass->getCard($post->after_content);

        // Category Columns
        $cardsCarouselClass = new CardsCarouselClass();
        $post->body = $cardsCarouselClass->getColumns($post->body);
        $post->before_content = $cardsCarouselClass->getColumns($post->before_content);
        $post->after_content = $cardsCarouselClass->getColumns($post->after_content);

        // Category Columns
        $columnClass = new ColumnsClass();
        $post->body = $columnClass->getColumns($post->body);
        $post->before_content = $columnClass->getColumns($post->before_content);
        $post->after_content = $columnClass->getColumns($post->after_content);

        // Stats Donate
        $statsDonateClass = new StatsDonateClass();
        $post->body = $statsDonateClass->getStatsDonate($post->body);
        $post->before_content = $statsDonateClass->getStatsDonate($post->before_content);
        $post->after_content = $statsDonateClass->getStatsDonate($post->after_content);

        // Stats Donate
        $communityGoalsClass = new CommunityGoalsClass();
        $post->body = $communityGoalsClass->getCommunityGoals($post->body);

        // Paypal Button
        $paypalButton = new PaypalButtonClass();
        $post->body = $paypalButton->getPaypalButton($post->body);

        // Gallery
        $storagePath = storage_path('app/public');
        $publicPath = public_path();
        //dump($storagePath,$publicPath);
        $galleryClass = new GalleryClass();
        //dump($post->body);
        $post->body = $galleryClass->getGallery($post->body, $storagePath, $publicPath);
        $post->before_content = $galleryClass->getGallery($post->before_content, $storagePath, $publicPath);
        $post->after_content = $galleryClass->getGallery($post->after_content, $storagePath, $publicPath);

        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
        //App::setLocale('en');

        return view('posts.show', compact('post'));
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::getCategoriesArray();

        return view('posts.edit', compact('post'))->with('categories', $categories);
    }

    /***************************************************************************/

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
            'body' => 'required',
            'category_id' => 'required',
        ]);

        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
        App::setLocale('en');

        $this->saveOnDb($request, $post);

        return redirect()->route('posts.index')
                        ->with('success', __('messages.article_updated_successfully'));
    }

    /***************************************************************************/

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
                        ->with('success', __('messages.article_deleted_successfully'));
    }

    /***************************************************************************/

    /**
     * Return the single post datas by post id [title, body, image].
     *
     * @param  int $post_id
     * @return \App\Post
     */
    public function postdata($post_id)
    {
        $ret = Post::where('id', $post_id)->first();
        //dump($ret);

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return the post by SLUG. (eg. http://websitename.com/post/xxxxx).
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function postBySlug($slug)
    {
        $post = Post::
                where('post_translations.slug', $slug)
                ->join('post_translations', 'posts.id', '=', 'post_translations.post_id')
                ->select('posts.*', 'post_translations.title', 'post_translations.body', 'post_translations.before_content', 'post_translations.after_content')
                ->first();

        return $this->show($post);
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return void
     */
    public function saveOnDb($request, $post)
    {
        $post->translateOrNew('en')->title = $request->get('title');
        //$post->body = $request->get('body');
        $post->translateOrNew('en')->body = clean($request->get('body'));
        $post->created_by = \Auth::user()->id;
        $post->translateOrNew('en')->slug = Str::slug($post->title, '-');
        $post->category_id = $request->get('category_id');

        $post->status = $request->get('status');
        $post->featured = $request->get('featured');

        // Intro image  picture upload
        if ($request->file('introimage')) {
            $introImagePictureFile = $request->file('introimage');
            $imageName = $introImagePictureFile->hashName();
            //$path = $introImagePictureFile->store('public/images/posts_intro_images');
            $post->introimage = $imageName;
        }

        $post->translateOrNew('en')->before_content = $request->get('before_content');
        $post->translateOrNew('en')->after_content = $request->get('after_content');

        $post->save();
    }
}
