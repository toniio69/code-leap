import './passkeys.js';
import { renderCourse } from './course-providers.js';

// Expose renderCourse globally for Blade components
if (typeof window !== 'undefined') {
    window.renderCourse = renderCourse;
}
