<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{--<sitemap>
        <loc>https://laravel-news.com/sitemap/posts</loc>
        <lastmod>{{Carbon\Carbon::parse($post->updated_at)->format('Y-m-d')}}</lastmod>
    </sitemap>
    <sitemap>
        <loc>https://laravel-news.com/sitemap/categories</loc>
        <lastmod>{{Carbon\Carbon::parse($post->updated_at)->format('Y-m-d')}}</lastmod>
    </sitemap>
    <sitemap>
        <loc>https://laravel-news.com/sitemap/podcasts</loc>
        <lastmod>{{Carbon\Carbon::parse($event->updated_at)->format('Y-m-d')}}</lastmod>
    </sitemap>--}}
    @foreach ($menuItems as $menuItem)
        <url>
            @if($menuItem->type == 2)
                <loc>{{env('APP_URL')}}{{ $menuItem->url }}</loc>
            @else
                <loc>{{ route($menuItem->route) }}</loc>
            @endif
            <lastmod>{{Carbon\Carbon::parse($menuItem->updated_at)->format('Y-m-d')}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</sitemapindex>
