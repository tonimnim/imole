<template>
    <div
        class="flex items-center justify-between px-3 py-2.5 bg-white border border-gray-200 rounded-lg hover:border-gray-300 transition-colors group"
    >
        <div class="flex items-center space-x-3 flex-1 min-w-0">
            <button class="lesson-drag-handle cursor-grab text-gray-300 hover:text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                </svg>
            </button>

            <!-- Lesson Type Icon -->
            <div :class="typeIconClass">
                <svg v-if="lesson.type === 'video'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <svg v-else-if="lesson.type === 'text'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <svg v-else-if="lesson.type === 'quiz'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <svg v-else-if="lesson.type === 'assignment'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>

            <!-- Lesson Info -->
            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">{{ index + 1 }}.</span>
                    <span class="text-sm font-medium text-gray-900 truncate">{{ lesson.title }}</span>
                </div>
            </div>

            <!-- Status Badges -->
            <div class="flex items-center space-x-2">
                <span
                    v-if="lesson.is_free"
                    class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded"
                >
                    Free Preview
                </span>
                <span
                    v-if="lesson.video_url && lesson.type === 'video'"
                    class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-700 rounded"
                >
                    Video
                </span>
                <span
                    v-if="!lesson.is_published"
                    class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-600 rounded"
                >
                    Draft
                </span>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-1 ml-3 opacity-0 group-hover:opacity-100 transition-opacity">
            <button
                @click="$emit('edit', lesson)"
                class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded"
                title="Edit Lesson"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </button>
            <button
                @click="$emit('delete', lesson)"
                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"
                title="Delete Lesson"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';

export default {
    name: 'LessonItem',
    props: {
        lesson: {
            type: Object,
            required: true,
        },
        index: {
            type: Number,
            required: true,
        },
    },
    emits: ['edit', 'delete'],
    setup(props) {
        const typeIconClass = computed(() => {
            const base = 'flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center';
            switch (props.lesson.type) {
                case 'video':
                    return `${base} bg-indigo-100 text-indigo-600`;
                case 'text':
                    return `${base} bg-green-100 text-green-600`;
                case 'quiz':
                    return `${base} bg-yellow-100 text-yellow-600`;
                case 'assignment':
                    return `${base} bg-purple-100 text-purple-600`;
                default:
                    return `${base} bg-gray-100 text-gray-600`;
            }
        });

        return {
            typeIconClass,
        };
    },
};
</script>
