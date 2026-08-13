<?php

namespace App\Http\Controllers;

use App\Services\FreeCodeCampService;
use Illuminate\Http\Request;
use Throwable;

class FreeCodeCampController extends Controller
{
    public function __construct(
        protected FreeCodeCampService $freeCodeCamp
    ) {
    }

    /**
     * Display the freeCodeCamp course catalog.
     */
    public function index(Request $request)
    {
        $search = trim(
            $request->input('search', '')
        );

        try {
            $curriculum = $this->freeCodeCamp->curriculum();

            $superblocks = $curriculum['curriculum']['superblocks']
                ?? [];

            $certifications = $curriculum['curriculum']['certifications']
                ?? [];

            /*
             * The API returns curriculum identifiers.
             * We use the search term against those identifiers
             * and then retrieve matching superblocks.
             */
            if ($search !== '') {
                $superblocks = collect($superblocks)
                    ->filter(function ($superblock) use ($search) {
                        return str_contains(
                            strtolower($superblock),
                            strtolower($search)
                        );
                    })
                    ->values()
                    ->all();
            }

            $courses = [];

            foreach (array_slice($superblocks, 0, 30) as $superblock) {

                $course = $this->freeCodeCamp
                    ->superblock($superblock);

                if (!$course) {
                    continue;
                }

                $course['dashedName'] = $superblock;

                $course['url'] = $this->freeCodeCamp
                    ->learnUrl($superblock);

                $courses[] = $course;
            }

            return view(
                'freecodecamp.index',
                compact(
                    'courses',
                    'search',
                    'certifications'
                )
            );

        } catch (Throwable $e) {

            report($e);

            return view(
                'freecodecamp.index',
                [
                    'courses' => [],
                    'search' => $search,
                    'certifications' => [],
                    'error' => 'Unable to load freeCodeCamp courses at the moment.',
                ]
            );
        }
    }

    /**
     * Display a specific freeCodeCamp course.
     */
    public function show(
        string $superblock
    ) {
        try {

            $course = $this->freeCodeCamp
                ->superblock($superblock);

            if (!$course) {
                abort(404);
            }

            $course['dashedName'] = $superblock;

            $course['url'] = $this->freeCodeCamp
                ->learnUrl($superblock);

            $chapters = $this->freeCodeCamp
                ->chapters($superblock);

            return view(
                'freecodecamp.show',
                compact(
                    'course',
                    'chapters'
                )
            );

        } catch (Throwable $e) {

            report($e);

            abort(503);
        }
    }

    /**
     * Display a specific chapter/module.
     */
    public function chapter(
        string $chapter
    ) {
        try {

            $modules = $this->freeCodeCamp
                ->modules($chapter);

            return view(
                'freecodecamp.chapter',
                compact(
                    'modules',
                    'chapter'
                )
            );

        } catch (Throwable $e) {

            report($e);

            abort(503);
        }
    }
}
