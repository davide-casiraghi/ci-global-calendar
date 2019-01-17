<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($posts as $post)
        <url>
            <loc>https://laravel-news.com/{{ $post->uri }}</loc>
            <lastmod>{{ $post->publishes_at }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
