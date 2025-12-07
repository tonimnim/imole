<template>
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <!-- Module Header -->
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <button class="module-drag-handle cursor-grab text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                    </svg>
                </button>
                <div class="flex items-center space-x-2">
                    <button @click="expanded = !expanded" class="text-gray-500 hover:text-gray-700">
                        <svg
                            class="w-5 h-5 transition-transform"
                            :class="{ 'rotate-90': expanded }"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <span class="text-sm font-medium text-gray-500">Section {{ index + 1 }}:</span>
                    <h3 class="font-semibold text-gray-900">{{ module.title }}</h3>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-xs text-gray-500">
                    {{ module.lessons?.length || 0 }} lessons
                </span>
                <button
                    @click="$emit('edit', module)"
                    class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded"
                    title="Edit Section"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </button>
                <button
                    @click="$emit('delete', module)"
                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"
                    title="Delete Section"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Lessons List -->
        <div v-show="expanded" class="p-4">
            <draggable
                v-model="localLessons"
                item-key="id"
                handle=".lesson-drag-handle"
                ghost-class="opacity-50"
                @end="onLessonsReorder"
                class="space-y-2"
            >
                <template #item="{ element: lesson, index: lessonIndex }">
                    <LessonItem
                        :lesson="lesson"
                        :index="lessonIndex"
                        @edit="$emit('edit-lesson', lesson)"
                        @delete="$emit('delete-lesson', lesson)"
                    />
                </template>
            </draggable>

            <!-- Empty State -->
            <div v-if="!module.lessons?.length" class="text-center py-6 text-gray-500">
                <p class="text-sm">No lessons yet. Add your first lesson below.</p>
            </div>

            <!-- Add Lesson Buttons -->
            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                <button
                    @click="$emit('add-lesson', module, 'video')"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                >
                    <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Video
                </button>
                <button
                    @click="$emit('add-lesson', module, 'text')"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                >
                    <svg class="w-4 h-4 mr-1.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Text
                </button>
                <button
                    @click="$emit('add-lesson', module, 'quiz')"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                >
                    <svg class="w-4 h-4 mr-1.5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Quiz
                </button>
                <button
                    @click="$emit('add-lesson', module, 'assignment')"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                >
                    <svg class="w-4 h-4 mr-1.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Assignment
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, watch } from 'vue';
import draggable from 'vuedraggable';
import LessonItem from './LessonItem.vue';

export default {
    name: 'ModuleItem',
    components: {
        draggable,
        LessonItem,
    },
    props: {
        module: {
            type: Object,
            required: true,
        },
        index: {
            type: Number,
            required: true,
        },
    },
    emits: ['edit', 'delete', 'add-lesson', 'edit-lesson', 'delete-lesson', 'lessons-reordered'],
    setup(props, { emit }) {
        const expanded = ref(true);
        const localLessons = ref(props.module.lessons || []);

        watch(() => props.module.lessons, (newLessons) => {
            localLessons.value = newLessons || [];
        }, { deep: true });

        const onLessonsReorder = () => {
            emit('lessons-reordered', props.module.id, localLessons.value);
        };

        return {
            expanded,
            localLessons,
            onLessonsReorder,
        };
    },
};
</script>
