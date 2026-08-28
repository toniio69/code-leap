export function renderCourse(courseData) {
    if (courseData.provider === 'youtube') {
        const iframe = document.createElement('iframe');
        iframe.src = `https://www.youtube.com/embed/${courseData.lessons[0].video_id}`;
        iframe.allow =
            'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
        iframe.allowFullscreen = true;
        iframe.className = 'aspect-video w-full rounded-lg';
        document.getElementById('video-player').appendChild(iframe);
    } else if (courseData.provider === 'openedx') {
        const button = document.createElement('a');
        button.href = courseData.enrollment_url;
        button.target = '_blank';
        button.rel = 'noopener noreferrer';
        button.className =
            'inline-flex items-center justify-center rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700';
        button.innerText = 'Enroll on codeleap';
        document.getElementById('course-cta').appendChild(button);
    } else if (courseData.provider === 'edX') {
        const card = document.createElement('div');
        card.className = 'overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200';

        const image = courseData.media
            ? `<img src="${courseData.media}" alt="${courseData.name}" class="h-40 w-full object-cover">`
            : `<div class="flex h-40 items-center justify-center bg-gray-100 text-sm text-gray-500">No image</div>`;

        card.innerHTML = `
            ${image}
            <div class="p-5">
                <p class="text-xs font-semibold text-gray-500">${courseData.organization ?? 'edX'}</p>
                <h3 class="mt-1 text-lg font-bold text-gray-900">${courseData.name}</h3>
                <p class="mt-1 text-sm text-gray-600">${courseData.code ?? ''}</p>
                <a href="https://courses.edx.org/courses/${courseData.id}/" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">View Course</a>
            </div>
        `;

        document.getElementById('course-list').appendChild(card);
    }
}