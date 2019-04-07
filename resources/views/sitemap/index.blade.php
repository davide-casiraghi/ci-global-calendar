<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
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
</urlset>
