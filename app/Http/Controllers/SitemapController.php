<?php

namespace App\Http\Controllers;

use App\Post;
use App\Event;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


/**
*    Created using this tutorial: https://laravel-news.com/laravel-sitemap
**/


class SitemapController extends Controller
{
    
    /***************************************************************************/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
      $post = Post::orderBy('updated_at', 'desc')->first();
      $event = Event::orderBy('updated_at', 'desc')->first();

      return response()->view('sitemap.index', [
          'post' => $post,
          'event' => $event,
      ])->header('Content-Type', 'text/xml');
    }
    
    /***************************************************************************/
    
    public function posts(){
        //$posts = Post::where('category_id', 6)->get();
        
        $posts =  DB::table('posts')
                       ->join('post_translations', 'posts.id', '=', 'post_translations.post_id')
                       ->select('posts.*', 'post_translations.locale', 'post_translations.slug')->get();
        
        //dd($posts);
        return response()->view('sitemap.posts', [
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml');
    }

    /***************************************************************************/
    
    public function events(){
        $events = Event::orderBy('updated_at', 'desc')->get();
        return response()->view('sitemap.events', [
            'events' => $events,
        ])->header('Content-Type', 'text/xml');
    }
        
    /***************************************************************************/
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(){        
        $sitemap = $this->generateSitemapXML();
        return view('sitemap.show',['sitemap' => $sitemap]);
    }
    
    /***************************************************************************/
    /**
     * Generate the sitemap XML
     *
     * @return \Illuminate\Http\Response
     */
    public function generateSitemapXML(){
        $ret = "";
        
        
        $ret .= "<?xml version='1.0' encoding='UTF-8'?>";
            $ret .= "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'> ";
                $ret .= "<url>";
                    $ret .= "<loc>http://www.example.com/foo.html</loc>";
                    $ret .= "<lastmod>2018-06-04</lastmod>";
                $ret .= "</url>";
        $ret .= "</urlset>";
        
        return $ret;
    }    
    
    
    
}
