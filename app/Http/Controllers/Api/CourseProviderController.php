<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseProviderController extends Controller
{
    /**
     * Fetch video lessons from a YouTube course playlist.
     */
    public function getYouTubeCourse(Request $request)
    {
        $request->validate([
            'playlist_id' => 'required|string',
        ]);

        $apiKey = config('services.youtube.api_key');
        $playlistId = $request->query('playlist_id');

        $response = Http::get('https://www.googleapis.com/youtube/v3/playlistItems', [
            'part' => 'snippet,contentDetails',
            'maxResults' => 50,
            'playlistId' => $playlistId,
            'key' => $apiKey,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Unable to fetch YouTube playlist'], 500);
        }

        $items = collect($response->json('items'))->map(function ($item) {
            return [
                'video_id' => $item['snippet']['resourceId']['videoId'],
                'title' => $item['snippet']['title'],
                'description' => $item['snippet']['description'],
                'thumbnail' => $item['snippet']['thumbnails']['high']['url'] ?? null,
                'published_at' => $item['snippet']['publishedAt'],
            ];
        });

        return response()->json([
            'provider' => 'youtube',
            'playlist_id' => $playlistId,
            'lessons' => $items,
        ]);
    }
}