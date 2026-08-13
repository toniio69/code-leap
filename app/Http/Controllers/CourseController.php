<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Services\FreeCodeCampService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function __construct(
        protected FreeCodeCampService $freeCodeCamp
    ) {
        $this->authorizeResource(Course::class, 'course');
    }

    public function index(Request $request)
    {
        $type = $request->query('type');

        $courses = Course::with('instructor')
            ->when($type === 'free', fn ($q) => $q->where('price', 0))
            ->when($type === 'premium', fn ($q) => $q->where('price', '>', 0))
            ->latest()
            ->get();

        try {
            $curriculum = $this->freeCodeCamp->curriculum();
            $superblocks = $curriculum['curriculum']['superblocks'] ?? [];

            foreach (array_slice($superblocks, 0, 30) as $superblock) {
                $course = $this->freeCodeCamp->superblock($superblock);

                if (!$course) {
                    continue;
                }

                $courses->push((object) [
                    'id' => 'fcc-' . $superblock,
                    'title' => $course['title'] ?? $superblock,
                    'description' => 'Explore this freeCodeCamp learning path and work through its coding challenges.',
                    'cover_image' => null,
                    'price' => 0,
                    'instructor' => (object) ['name' => 'freeCodeCamp'],
                    'user_id' => null,
                    'source' => 'freecodecamp',
                    'dashedName' => $superblock,
                    'url' => $this->freeCodeCamp->learnUrl($superblock),
                    'blocks' => $course['blocks'] ?? [],
                ]);
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return view('courses.index', compact('courses', 'type'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        return view(
            'courses.edit',
            compact('course')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'cover_image' => [
                'nullable',
                'image',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] =
                $request->file('cover_image')
                    ->store('course-covers', 'public');
        }

        $validated['user_id'] = auth()->id();

        Course::create($validated);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function update(
        Request $request,
        Course $course
    ) {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'cover_image' => [
                'nullable',
                'image',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] =
                $request->file('cover_image')
                    ->store('course-covers', 'public');
        }

        $course->update($validated);

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function show(Course $course)
    {
        $course->load([
            'instructor',
            'students',
            'materials',
        ]);

        return view('courses.show', compact('course'));
    }

    public function enroll(Course $course)
    {
        $course->students()->syncWithoutDetaching(auth()->id());

        return redirect()->route('courses.show', $course->getKey())->with('success', 'Enrolled successfully!');
    }

    public function storeMaterial(
        Request $request,
        Course $course
    ) {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => [
                'required',
                'file',
                'mimes:pdf,mp4,mov,avi',
                'max:51200',
            ],
        ]);

        $path = $request->file('file')
            ->store('course-materials', 'public');

        $course->materials()->create([
            'title' => $validated['title'],
            'file_path' => $path,
        ]);

        return back()->with(
            'success',
            'Material uploaded successfully.'
        );
    }

    public function downloadMaterial(CourseMaterial $material)
    {
        $this->authorize('viewContent', $material->course);

        $filePath = Storage::disk('public')->path($material->getAttribute('file_path'));

        return response()->download($filePath, basename($material->getAttribute('file_path')));
    }
}
