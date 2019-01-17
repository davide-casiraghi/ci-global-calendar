<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    
    
    public function index()
    {
      $post = Post::active()->orderBy('updated_at', 'desc')->first();
      $podcast = Podcast::active()->orderBy('updated_at', 'desc')->first();

      return response()->view('sitemap.index', [
          'post' => $post,
          'podcast' => $podcast,
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
