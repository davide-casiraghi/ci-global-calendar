<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($events as $event)
        <url>
            <loc>{{env('APP_URL')}}event/{{ $event->slug }}</loc>
            <lastmod>{{ $event->updated_at }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
