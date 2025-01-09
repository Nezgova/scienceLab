<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NewsController extends Controller
{
    private $apiKey;
    private $cacheTimeout = 3600; // 1 hour cache
    private $perPage = 12; // Show more articles per page
    
    public function __construct()
    {
        $this->apiKey = env('NEWS_API_KEY');
    }

    public function index(Request $request)
    {
        $searchQuery = $request->query('search', '');
        $page = $request->query('page', 1);
        
        // Create a cache key that includes the search query
        $cacheKey = 'tech_news_' . md5($searchQuery) . '_' . $page;

        try {
            $articles = Cache::remember($cacheKey, $this->cacheTimeout, function () use ($searchQuery, $page) {
                // Fetch more articles per request to ensure we have enough after filtering
                $response = Http::get('https://newsapi.org/v2/everything', [
                    'q' => $searchQuery ?: 'technology OR software OR programming OR artificial intelligence',
                    'apiKey' => $this->apiKey,
                    'language' => 'en',
                    'pageSize' => 100,
                    'sortBy' => 'publishedAt',
                    'page' => ceil($page / 2), // Adjust API pagination based on our local pagination
                ]);

                if (!$response->successful()) {
                    throw new \Exception('Failed to fetch news: ' . $response->body());
                }

                return $response->json()['articles'] ?? [];
            });

            // Convert to collection for easier manipulation
            $articles = collect($articles)
                ->filter(function ($article) {
                    return 
                        !empty($article['urlToImage']) && 
                        !empty($article['description']) && 
                        empty($article['deleted_at']) &&
                        $this->isValidImageUrl($article['urlToImage']);
                })
                ->map(function ($article) {
                    return array_merge($article, [
                        'description' => $this->cleanDescription($article['description']),
                        'publishedAt' => Carbon::parse($article['publishedAt'])->diffForHumans(),
                    ]);
                });

            // Paginate the filtered results
            $paginatedArticles = new LengthAwarePaginator(
                $articles->forPage($page, $this->perPage),
                $articles->count(),
                $this->perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('news', [
                'articles' => $paginatedArticles,
                'searchQuery' => $searchQuery,
            ]);

        } catch (\Exception $e) {
            // Log the error and return an empty collection with pagination
            Log::error('News API Error: ' . $e->getMessage());
            
            $emptyPaginator = new LengthAwarePaginator(
                [],
                0,
                $this->perPage,
                1,
                ['path' => $request->url()]
            );

            return view('news', [
                'articles' => $emptyPaginator,
                'searchQuery' => $searchQuery,
                'error' => 'Unable to fetch news at this time. Please try again later.'
            ]);
        }
    }

    private function cleanDescription($description)
    {
        // Remove any HTML tags and decode HTML entities
        $description = strip_tags(html_entity_decode($description));
        
        // Trim to reasonable length while keeping whole words
        return Str::words($description, 30, '...');
    }

    private function isValidImageUrl($url)
    {
        // Basic URL validation
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        // Check if it's an image URL
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $urlPath = parse_url($url, PHP_URL_PATH);
        $extension = strtolower(pathinfo($urlPath, PATHINFO_EXTENSION));
        
        return in_array($extension, $imageExtensions);
    }
}