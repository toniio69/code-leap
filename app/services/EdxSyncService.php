<?php

namespace App\Services;

use App\Models\EdxCourse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class EdxSyncService
{
    protected string $apiUrl = 'https://courses.edx.org/api/courses/v1/courses/';

    protected int $pageSize = 50;

    /**
     * Fetch and sync courses from edX API.
     */
    public function sync(array $filters = []): array
    {
        $stats = ['fetched' => 0, 'created' => 0, 'updated' => 0, 'failed' => 0];

        try {
            $response = Http::timeout(30)
                ->retry(2, 1000)
                ->get($this->apiUrl, array_merge([
                    'page_size' => $this->pageSize,
                ], $filters));

            if ($response->failed()) {
                Log::error('edX API request failed', ['status' => $response->status()]);
                $stats['failed'] = 1;
                return $stats;
            }

            $results = $response->json('results', []);

            foreach ($results as $courseData) {
                $stats['fetched']++;
                try {
                    $edxId = $courseData['id'] ?? null;
                    if (!$edxId) {
                        $stats['failed']++;
                        continue;
                    }

                    $attributes = $this->mapCourseData($courseData);
                    $edxCourse = EdxCourse::updateOrCreate(
                        ['edx_id' => $edxId],
                        $attributes
                    );

                    if ($edxCourse->wasRecentlyCreated) {
                        $stats['created']++;
                    } else {
                        $stats['updated']++;
                    }
                } catch (Throwable $e) {
                    Log::error('Failed to sync edX course', [
                        'course_data' => $courseData ?? [],
                        'error' => $e->getMessage(),
                    ]);
                    $stats['failed']++;
                }
            }

            // Check for pagination
            $next = $response->json('next');
            if ($next) {
                Log::info('edX API has more pages', ['next' => $next]);
            }

        } catch (Throwable $e) {
            Log::error('edX sync exception', ['error' => $e->getMessage()]);
            $stats['failed'] = max($stats['failed'], 1);
        }

        return $stats;
    }

    /**
     * Map edX API course data to our database schema.
     */
    protected function mapCourseData(array $courseData): array
    {
        $courseUrl = $courseData['course_url'] ?? null;
        $enrollmentUrl = $courseData['enrollment_url'] ?? $courseUrl;

        return [
            'edx_id' => $courseData['id'],
            'title' => $courseData['name'] ?? 'Untitled Course',
            'description' => $courseData['description'] ?? null,
            'code' => $courseData['number'] ?? null,
            'organization' => $courseData['org'] ?? null,
            'run' => $courseData['run'] ?? null,
            'image_url' => $courseData['media']['course_image']['uri'] ?? null,
            'start_date' => $courseData['start'] ?? null,
            'end_date' => $courseData['end'] ?? null,
            'enrollment_url' => $enrollmentUrl,
            'integrity_url' => $courseUrl ? $courseUrl . '/agreements/integrity' : null,
            'provider' => 'edX',
            'status' => $courseData['status'] ?? 'published',
        ];
    }

    /**
     * Search mirrored courses locally.
     */
    public function search(string $query, int $limit = 20)
    {
        return EdxCourse::query()
            ->when($query, function ($q, $query) {
                $q->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('organization', 'like', "%{$query}%")
                      ->orWhere('code', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->limit($limit)
            ->get();
    }
}