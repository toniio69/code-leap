<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class EdxCourseController extends Controller
{
    public function searchCourses(Request $request)
    {
        $search = $request->query('query', 'programming');

        try {
            $response = Http::timeout(4)->get('https://courses.edx.org/api/courses/v1/courses/', [
                'search_term' => $search,
                'page_size' => 10,
            ]);

            if ($response->successful() && !empty($response->json('results'))) {
                $courses = collect($response->json('results'))->map(function ($course) {
                    return [
                        'id' => $course['id'] ?? uniqid(),
                        'name' => $course['name'] ?? 'Untitled Course',
                        'code' => $course['number'] ?? 'CS101',
                        'organization' => $course['org'] ?? 'edX Partner',
                        'start' => $course['start'] ?? now()->toIso8601String(),
                        'media' => $course['media']['course_image']['uri'] ?? null,
                        'provider' => 'edX',
                    ];
                });

                return response()->json($courses);
            }
        } catch (Throwable $e) {
            // Fall through to fallback catalog
        }

        // Curated fallback programming courses when offline or rate-limited
        $fallbackCatalog = collect([
            [
                'id' => 'course-v1:HarvardX+CS50+X',
                'name' => 'CS50\'s Introduction to Computer Science',
                'code' => 'CS50x',
                'organization' => 'HarvardX',
                'start' => now()->toIso8601String(),
                'media' => 'https://prod-discovery.edx-cdn.org/media/course/image/0e575a39-da1e-4e33-bb3b-e96cc6ffced8-8772c422ba5b.small.png',
                'provider' => 'edX',
            ],
            [
                'id' => 'course-v1:MITx+6.00.1x+2T2024',
                'name' => 'Introduction to Computer Science and Programming Using Python',
                'code' => '6.00.1x',
                'organization' => 'MITx',
                'start' => now()->toIso8601String(),
                'media' => 'https://prod-discovery.edx-cdn.org/media/course/image/1c310a0e-cd05-4c07-ba71-6c2e742880b9-122e2bbcf934.small.jpg',
                'provider' => 'edX',
            ],
            [
                'id' => 'course-v1:W3Cx+JS.0x+2T2024',
                'name' => 'JavaScript Basics & Web Development',
                'code' => 'JS.0x',
                'organization' => 'W3Cx',
                'start' => now()->toIso8601String(),
                'media' => 'https://prod-discovery.edx-cdn.org/media/course/image/09daea78-436f-4d9f-a89e-2dc2a58b09da-e4ce5f12e847.small.jpg',
                'provider' => 'edX',
            ],
        ]);

        $filtered = $fallbackCatalog->filter(function ($item) use ($search) {
            if (empty($search)) return true;
            return str_contains(strtolower($item['name']), strtolower($search)) ||
                   str_contains(strtolower($item['organization']), strtolower($search)) ||
                   str_contains(strtolower($item['code']), strtolower($search));
        })->values();

        return response()->json($filtered->isNotEmpty() ? $filtered : $fallbackCatalog);
    }
}