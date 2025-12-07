<template>
    <div class="fixed inset-0 z-50 overflow-hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-30" @click="$emit('close')"></div>

        <!-- Slide-out Panel -->
        <div class="absolute inset-y-0 right-0 max-w-xl w-full bg-white shadow-xl flex flex-col h-full">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Edit Lesson</h2>
                    <p class="text-sm text-gray-500">{{ module?.title }}</p>
                </div>
                <button
                    @click="$emit('close')"
                    class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6 min-h-0">
                <form @submit.prevent="save" class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input
                            v-model="form.title"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required
                        >
                    </div>

                    <!-- Type Indicator (read-only) -->
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div
                            :class="[
                                'flex items-center justify-center w-10 h-10 rounded-lg',
                                form.type === 'video' ? 'bg-indigo-100 text-indigo-600' :
                                form.type === 'text' ? 'bg-green-100 text-green-600' :
                                form.type === 'quiz' ? 'bg-yellow-100 text-yellow-600' :
                                'bg-purple-100 text-purple-600'
                            ]"
                        >
                            <span v-html="getLessonTypeIcon(form.type)"></span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ getLessonTypeLabel(form.type) }} Lesson</p>
                            <p class="text-xs text-gray-500">Type cannot be changed after creation</p>
                        </div>
                    </div>

                    <!-- Video URL (for video type) -->
                    <div v-if="form.type === 'video'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Video URL</label>
                        <input
                            v-model="form.video_url"
                            type="url"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="https://youtube.com/watch?v=... or https://vimeo.com/..."
                        >
                        <p class="mt-1 text-xs text-gray-500">Paste a YouTube or Vimeo URL</p>

                        <!-- Video Preview -->
                        <div v-if="videoEmbedUrl" class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                            <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden max-h-48">
                                <iframe
                                    :src="videoEmbedUrl"
                                    class="w-full h-full"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Content (for text/quiz/assignment) -->
                    <div v-if="form.type !== 'video' || form.type === 'video'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ form.type === 'video' ? 'Description (optional)' : 'Content' }}
                        </label>
                        <textarea
                            v-model="form.content"
                            rows="8"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            :placeholder="contentPlaceholder"
                        ></textarea>
                        <p class="mt-1 text-xs text-gray-500">Supports basic Markdown formatting</p>
                    </div>

                    <!-- Quiz Builder Link (for quiz type) -->
                    <div v-if="form.type === 'quiz'" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-yellow-800">Quiz Questions</h4>
                                <p class="text-sm text-yellow-700 mt-1">
                                    After saving this lesson, you can add quiz questions from the Quizzes section in the teacher panel.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Assignment Info (for assignment type) -->
                    <div v-if="form.type === 'assignment'" class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-purple-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-purple-800">Assignment Details</h4>
                                <p class="text-sm text-purple-700 mt-1">
                                    Use the content field above to describe the assignment. Students will be able to submit their work through the course page.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="space-y-4 pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900">Settings</h3>

                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input
                                v-model="form.is_free"
                                type="checkbox"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                            >
                            <div>
                                <span class="text-sm font-medium text-gray-700">Free Preview</span>
                                <p class="text-xs text-gray-500">Allow non-enrolled students to view this lesson</p>
                            </div>
                        </label>

                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input
                                v-model="form.is_published"
                                type="checkbox"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                            >
                            <div>
                                <span class="text-sm font-medium text-gray-700">Published</span>
                                <p class="text-xs text-gray-500">Make this lesson visible to enrolled students</p>
                            </div>
                        </label>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">
                <button
                    @click="$emit('delete', lesson)"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg"
                >
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete Lesson
                </button>
                <div class="flex items-center space-x-3">
                    <button
                        type="button"
                        @click="$emit('close')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800"
                    >
                        Cancel
                    </button>
                    <button
                        @click="save"
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700"
                    >
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, watch } from 'vue';

export default {
    name: 'LessonEditor',
    props: {
        lesson: {
            type: Object,
            required: true,
        },
        module: {
            type: Object,
            default: null,
        },
    },
    emits: ['close', 'save', 'delete'],
    setup(props, { emit }) {
        const form = ref({
            id: props.lesson.id,
            title: props.lesson.title || '',
            type: props.lesson.type || 'video',
            content: props.lesson.content || '',
            video_url: props.lesson.video_url || '',
            is_free: props.lesson.is_free || false,
            is_published: props.lesson.is_published || false,
        });

        const lessonTypes = [
            { value: 'video', label: 'Video', icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' },
            { value: 'text', label: 'Text', icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>' },
            { value: 'quiz', label: 'Quiz', icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' },
            { value: 'assignment', label: 'Assignment', icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>' },
        ];

        const contentPlaceholder = computed(() => {
            switch (form.value.type) {
                case 'video':
                    return 'Add a description for this video lesson...';
                case 'text':
                    return 'Write your lesson content here. You can use Markdown for formatting...';
                case 'quiz':
                    return 'Add instructions for students before they take the quiz...';
                case 'assignment':
                    return 'Describe the assignment requirements and what students need to submit...';
                default:
                    return 'Enter lesson content...';
            }
        });

        const getLessonTypeIcon = (type) => {
            const found = lessonTypes.find(t => t.value === type);
            return found?.icon || '';
        };

        const getLessonTypeLabel = (type) => {
            const found = lessonTypes.find(t => t.value === type);
            return found?.label || 'Lesson';
        };

        const videoEmbedUrl = computed(() => {
            const url = form.value.video_url;
            if (!url) return null;

            // YouTube
            const youtubeMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/);
            if (youtubeMatch) {
                return `https://www.youtube.com/embed/${youtubeMatch[1]}`;
            }

            // Vimeo
            const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
            if (vimeoMatch) {
                return `https://player.vimeo.com/video/${vimeoMatch[1]}`;
            }

            return null;
        });

        const save = () => {
            emit('save', { ...form.value });
        };

        watch(() => props.lesson, (newLesson) => {
            form.value = {
                id: newLesson.id,
                title: newLesson.title || '',
                type: newLesson.type || 'video',
                content: newLesson.content || '',
                video_url: newLesson.video_url || '',
                is_free: newLesson.is_free || false,
                is_published: newLesson.is_published || false,
            };
        }, { deep: true });

        return {
            form,
            lessonTypes,
            contentPlaceholder,
            videoEmbedUrl,
            getLessonTypeIcon,
            getLessonTypeLabel,
            save,
        };
    },
};
</script>
