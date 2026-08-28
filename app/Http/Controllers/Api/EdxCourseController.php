<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EdxCourseController extends Controller
{
    public function searchCourses(Request $request)
    {
        $search = $request->query('query', 'programming');

        $response = Http::get('https://courses.edx.org/api/courses/v1/courses/', [
            'search_term' => $search,
            'page_size' => 10,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Unable to fetch edX courses'], 500);
        }

        $courses = collect($response->json('results'))->map(function ($course) {
            return [
                'id' => $course['id'],
                'name' => $course['name'],
                'code' => $course['number'],
                'organization' => $course['org'],
                'start' => $course['start'],
                'media' => $course['media']['course_image']['uri'] ?? null,
                'provider' => 'edX',
            ];
        });

        return response()->json($courses);
    }
}