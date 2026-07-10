<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoAndDiscoveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_has_meta_description_and_organization_jsonld(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('name="description"', false);
        $response->assertSee('property="og:title"', false);
        $response->assertSee('twitter:card', false);
        $response->assertSee('MedicalOrganization', false);
    }

    public function test_post_show_has_article_structured_data(): void
    {
        $post = Post::factory()->create([
            'title' => 'CAMPANHA DE VACINACAO INFANTIL',
            'slug' => 'campanha-vacinacao',
            'excerpt' => 'Resumo curto da campanha para o compartilhamento.',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/noticias/'.$post->slug);

        $response->assertOk();
        $response->assertSee('NewsArticle', false);
        $response->assertSee('og:type', false);
        $response->assertSee('Resumo curto da campanha', false);
    }

    public function test_home_uses_default_share_image_from_settings(): void
    {
        SiteSetting::set('seo_image', 'https://cdn.exemplo.com/share.jpg');

        $this->get('/')->assertSee('https://cdn.exemplo.com/share.jpg', false);
    }

    public function test_sitemap_lists_published_content(): void
    {
        Post::factory()->create([
            'slug' => 'noticia-no-sitemap',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee('/noticias/noticia-no-sitemap', false);
        $response->assertSee('<urlset', false);
    }

    public function test_sitemap_excludes_draft_posts(): void
    {
        Post::factory()->create([
            'slug' => 'rascunho-oculto-sitemap',
            'published_at' => null,
        ]);

        $this->get('/sitemap.xml')->assertDontSee('rascunho-oculto-sitemap');
    }

    public function test_rss_feed_lists_latest_news(): void
    {
        Post::factory()->create([
            'title' => 'NOTICIA NO FEED RSS',
            'slug' => 'noticia-feed',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get('/feed');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
        $response->assertSee('<rss', false);
        $response->assertSee('NOTICIA NO FEED RSS', false);
    }

    public function test_robots_txt_points_to_sitemap_and_hides_admin(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertSee('Sitemap:', false);
        $response->assertSee('Disallow: /admin', false);
    }
}
