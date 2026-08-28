<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function index(Course $course): View
    {
        $this->authorize('view', $course);

        $lessons = $course->lessons()->latest()->get();

        return view('lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course): View
    {
        $this->authorize('update', $course);

        return view('lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'starter_code' => ['nullable', 'string'],
        ]);

        $course->lessons()->create($validated);

        return redirect()
            ->route('courses.lessons.index', $course)
            ->with('success', 'Lesson created successfully.');
    }

    public function edit(Course $course, Lesson $lesson): View
    {
        $this->authorize('update', $course);

        return view('lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'starter_code' => ['nullable', 'string'],
        ]);

        $lesson->update($validated);

        return redirect()
            ->route('courses.lessons.index', $course)
            ->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Course $course, Lesson $lesson): RedirectResponse
    {
        $this->authorize('update', $course);

        $lesson->delete();

        return redirect()
            ->route('courses.lessons.index', $course)
            ->with('success', 'Lesson deleted successfully.');
    }
}