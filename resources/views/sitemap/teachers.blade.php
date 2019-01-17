<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($teachers as $teacher)
        <url>
            <loc>{{env('APP_URL')}}teachers/{{ $teacher->slug }}</loc>
            <lastmod>{{ $teacher->updated_at }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
