<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $courses = Course::query()
            ->where('is_published', true)
            ->select(['slug', 'title', 'thumbnail', 'updated_at'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $categories = Category::query()
            ->select(['slug', 'updated_at'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $content = view('sitemap', [
            'courses' => $courses,
            'categories' => $categories,
        ])->render();

        return response($content)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=3600, s-maxage=3600');
    }

    public function robots(): Response
    {
        $sitemapUrl = url('/sitemap.xml');

        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'Disallow: /student/',
            'Disallow: /teacher/',
            'Disallow: /admin/',
            'Disallow: /dashboard',
            'Disallow: /cart',
            'Disallow: /checkout',
            'Disallow: /learn/',
            'Disallow: /api/',
            '',
            "Sitemap: {$sitemapUrl}",
            '',
            'Crawl-delay: 1',
        ]);

        return response($content)
            ->header('Content-Type', 'text/plain');
    }
}
