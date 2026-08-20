<?php

namespace App\Http\Controllers;

use App\Services\FreeCodeCampService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class FreeCodeCampController extends Controller
{
    public function __construct(
        protected FreeCodeCampService $freeCodeCamp
    ) {}

    /**
     * Display the freeCodeCamp course catalog.
     */
    public function index(Request $request): View
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
                $superblocks = array_values(array_filter($superblocks, function ($superblock) use ($search) {
                    return str_contains(
                        strtolower($superblock),
                        strtolower($search)
                    );
                }));
            }

            $courses = [];

            foreach (array_slice($superblocks, 0, 30) as $superblock) {

                $course = $this->freeCodeCamp
                    ->superblock($superblock);

                if (! $course) {
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
    public function show(string $superblock): View
    {
        try {

            $course = $this->freeCodeCamp
                ->superblock($superblock);

            if (! $course) {
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
    public function chapter(string $chapter): View
    {
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
