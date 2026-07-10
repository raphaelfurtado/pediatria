<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Publication;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SeoController extends Controller
{
    /**
     * XML sitemap for search engines (static pages + published content).
     */
    public function sitemap()
    {
        $urls = [];

        // Static, always-available pages.
        foreach ([
            'home', 'posts.index', 'publications.index', 'events.index',
            'gallery.index', 'videos.index', 'pages.about', 'pages.contact',
            'pages.privacy', 'pages.terms',
        ] as $routeName) {
            $urls[] = [
                'loc' => route($routeName),
                'lastmod' => now()->toAtomString(),
                'changefreq' => 'weekly',
            ];
        }

        // Published news.
        foreach (Post::published()->latest('published_at')->get() as $post) {
            $urls[] = [
                'loc' => route('posts.show', $post->slug),
                'lastmod' => ($post->updated_at ?? $post->published_at)?->toAtomString(),
                'changefreq' => 'monthly',
            ];
        }

        // Publications library.
        foreach (Publication::latest()->get() as $publication) {
            if (empty($publication->slug)) {
                continue;
            }
            $urls[] = [
                'loc' => route('publications.show', $publication->slug),
                'lastmod' => ($publication->updated_at ?? $publication->created_at)?->toAtomString(),
                'changefreq' => 'yearly',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls as $url) {
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.htmlspecialchars($url['loc'], ENT_XML1).'</loc>'."\n";
            if (! empty($url['lastmod'])) {
                $xml .= '    <lastmod>'.$url['lastmod'].'</lastmod>'."\n";
            }
            $xml .= '    <changefreq>'.$url['changefreq'].'</changefreq>'."\n";
            $xml .= '  </url>'."\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /**
     * RSS 2.0 feed of the latest published news.
     */
    public function feed()
    {
        $posts = Post::published()->latest('published_at')->take(20)->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'."\n";
        $xml .= '  <channel>'."\n";
        $xml .= '    <title>SOPAPE — Notícias</title>'."\n";
        $xml .= '    <link>'.htmlspecialchars(route('posts.index'), ENT_XML1).'</link>'."\n";
        $xml .= '    <description>Últimas notícias da Sociedade Paraense de Pediatria (SOPAPE).</description>'."\n";
        $xml .= '    <language>pt-BR</language>'."\n";
        $xml .= '    <atom:link href="'.htmlspecialchars(route('feed'), ENT_XML1).'" rel="self" type="application/rss+xml" />'."\n";

        foreach ($posts as $post) {
            $link = route('posts.show', $post->slug);
            $description = (string) Str::of(strip_tags($post->excerpt ?? ''))->squish()->limit(300);
            $xml .= '    <item>'."\n";
            $xml .= '      <title>'.htmlspecialchars($post->title, ENT_XML1).'</title>'."\n";
            $xml .= '      <link>'.htmlspecialchars($link, ENT_XML1).'</link>'."\n";
            $xml .= '      <guid isPermaLink="true">'.htmlspecialchars($link, ENT_XML1).'</guid>'."\n";
            $xml .= '      <description>'.htmlspecialchars($description, ENT_XML1).'</description>'."\n";
            if ($post->published_at) {
                $xml .= '      <pubDate>'.Carbon::parse($post->published_at)->toRssString().'</pubDate>'."\n";
            }
            if ($post->category) {
                $xml .= '      <category>'.htmlspecialchars($post->category, ENT_XML1).'</category>'."\n";
            }
            $xml .= '    </item>'."\n";
        }

        $xml .= '  </channel>'."\n";
        $xml .= '</rss>';

        return response($xml, 200, ['Content-Type' => 'application/rss+xml; charset=UTF-8']);
    }

    /**
     * robots.txt pointing crawlers at the sitemap and hiding private areas.
     */
    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /area-do-socio',
            'Disallow: /login',
            'Disallow: /redefinir-senha',
            'Allow: /',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
