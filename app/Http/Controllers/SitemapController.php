<?php

namespace App\Http\Controllers;

use App\Post;
use App\Event;
use App\Teacher;
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
      $teacher = Teacher::orderBy('updated_at', 'desc')->first();

      return response()->view('sitemap.index', [
          'post' => $post,
          'event' => $event,
          'teacher' => $teacher,
      ])->header('Content-Type', 'text/xml');
    }
    
    /***************************************************************************/
    /**
     * Generate the posts XML sitemap 
     *
     * @return \Illuminate\Http\Response
     */
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
    /**
     * Generate the events XML sitemap 
     *
     * @return \Illuminate\Http\Response
     */
    public function events(){
        
        // search start from today's date
            date_default_timezone_set('Europe/Rome');
            $searchStartDate = date('Y-m-d', time());

        // Get lastest event repetitions
            $lastestEventsRepetitions = DB::table('event_repetitions')
                ->selectRaw('event_id, MIN(id) AS rp_id, start_repeat, end_repeat')
                ->where('event_repetitions.start_repeat', '>=',$searchStartDate)
                ->groupBy('event_id');
                            
        // Retrieve the events 
            $events = DB::table('events')
                ->joinSub($lastestEventsRepetitions, 'event_repetitions', function ($join) use ($searchStartDate) {
                    $join->on('events.id', '=', 'event_repetitions.event_id');
                })
                ->orderBy('event_repetitions.start_repeat', 'asc')
                ->get();
                    
        return response()->view('sitemap.events', [
            'events' => $events,
        ])->header('Content-Type', 'text/xml');
    }
    
    /***************************************************************************/
    /**
     * Generate the teachers XML sitemap 
     *
     * @return \Illuminate\Http\Response
     */
    public function teachers(){
        $teachers = Teacher::orderBy('updated_at', 'desc')->get();
        return response()->view('sitemap.teachers', [
            'teachers' => $teachers,
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
 
    
    
}
