<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OpenEdXCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpenEdXController extends Controller
{
    public function getCourses(Request $request)
    {
        $courses = OpenEdXCourse::query()
            ->when($request->filled('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return response()->json([
            'provider' => 'openedx',
            'courses' => $courses,
        ]);
    }

    public function getIntegritySignature(Request $request, string $courseId)
    {
        $request->validate([
            'username' => 'nullable|string',
        ]);

        $baseUrl = rtrim(config('services.openedx.base_url'), '/');
        $username = $request->query('username', '');
        $url = "{$baseUrl}/agreements/v1/integrity_signature/{$courseId}";

        $response = Http::withToken(config('services.openedx.access_token'))
            ->get($url, [
                'username' => $username,
            ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Unable to fetch integrity signature'], $response->status());
        }

        return response()->json($response->json());
    }
}