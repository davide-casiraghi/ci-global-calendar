<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($teachers as $teacher)
        <url>
            <loc>{{env('APP_URL')}}teacher/{{ $teacher->slug }}</loc>
            <lastmod>{{Carbon\Carbon::parse($teacher->updated_at)->format('Y-m-d')}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
