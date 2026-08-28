export function renderCourse(courseData, containerId = 'course-list') {
    if (!courseData) return;

    if (courseData.provider === 'youtube') {
        const playerContainer = document.getElementById('video-player');
        if (playerContainer && courseData.lessons?.[0]?.video_id) {
            playerContainer.innerHTML = '';
            const iframe = document.createElement('iframe');
            iframe.src = `https://www.youtube.com/embed/${courseData.lessons[0].video_id}`;
            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
            iframe.allowFullscreen = true;
            iframe.className = 'aspect-video w-full rounded-xl border border-border bg-black shadow-sm';
            playerContainer.appendChild(iframe);
        }
    } else if (courseData.provider === 'openedx') {
        const ctaContainer = document.getElementById('course-cta');
        if (ctaContainer && courseData.enrollment_url) {
            ctaContainer.innerHTML = '';
            const button = document.createElement('a');
            button.href = courseData.enrollment_url;
            button.target = '_blank';
            button.rel = 'noopener noreferrer';
            button.className = 'inline-flex items-center justify-center rounded-lg bg-primary text-primary-foreground px-6 py-3 text-sm font-semibold shadow-sm transition-colors hover:bg-primary/90';
            button.innerText = 'Enroll on Code Leap';
            ctaContainer.appendChild(button);
        }
    } else if (courseData.provider === 'edX' || !courseData.provider) {
        const targetContainer = document.getElementById(containerId);
        if (!targetContainer) return;

        const card = document.createElement('div');
        card.className = 'group flex flex-col justify-between overflow-hidden rounded-xl border border-border bg-card text-card-foreground shadow-sm transition-all hover:shadow-md';

        const image = courseData.media
            ? `<div class="aspect-video w-full overflow-hidden bg-muted"><img src="${courseData.media}" alt="${courseData.name}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" onerror="this.parentElement.innerHTML='<div class=\\'flex h-full items-center justify-center text-xs text-muted-foreground\\'>Online Course</div>'"></div>`
            : `<div class="flex aspect-video w-full items-center justify-center bg-muted text-xs font-medium text-muted-foreground">edX Online Course</div>`;

        card.innerHTML = `
            <div>
                ${image}
                <div class="p-5">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="inline-flex items-center rounded-full bg-primary/10 px-2.5 py-0.5 text-xs font-semibold text-primary">
                            ${courseData.organization || 'edX'}
                        </span>
                        <span class="text-xs text-muted-foreground font-mono">
                            ${courseData.code || 'Verified'}
                        </span>
                    </div>
                    <h3 class="text-base font-semibold leading-tight tracking-tight text-foreground line-clamp-2">${courseData.name}</h3>
                    <p class="mt-2 text-xs text-muted-foreground flex items-center gap-1">
                        <span>Partner Institution: ${courseData.organization || 'Global University'}</span>
                    </p>
                </div>
            </div>
            <div class="p-5 pt-0">
                <a href="${courseData.id ? `https://courses.edx.org/courses/${courseData.id}/` : '#'}" target="_blank" rel="noopener noreferrer" class="inline-flex w-full items-center justify-center rounded-md bg-primary px-4 py-2 text-xs font-medium text-primary-foreground transition-colors hover:bg-primary/90">
                    View on edX
                </a>
            </div>
        `;

        targetContainer.appendChild(card);
    }
}