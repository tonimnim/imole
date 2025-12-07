<template>
    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 hover:border-gray-300 transition-colors">
        <div class="flex items-start space-x-3">
            <!-- Drag Handle -->
            <button class="question-drag-handle cursor-grab text-gray-400 hover:text-gray-600 mt-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                </svg>
            </button>

            <!-- Question Number -->
            <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center text-sm font-semibold">
                {{ index + 1 }}
            </div>

            <!-- Question Content -->
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-gray-900 font-medium">{{ question.question_text }}</p>
                        <div class="flex items-center space-x-3 mt-2">
                            <span :class="typeClass" class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full">
                                {{ typeLabel }}
                            </span>
                            <span class="text-xs text-gray-500">{{ question.points }} point{{ question.points !== 1 ? 's' : '' }}</span>
                        </div>

                        <!-- Options Preview (for multiple choice) -->
                        <div v-if="question.question_type === 'multiple_choice' && question.options?.length" class="mt-3 space-y-1">
                            <div
                                v-for="(option, optIndex) in question.options.slice(0, 4)"
                                :key="optIndex"
                                class="flex items-center space-x-2 text-sm"
                            >
                                <span
                                    :class="[
                                        'w-5 h-5 rounded-full flex items-center justify-center text-xs',
                                        option === question.correct_answer
                                            ? 'bg-green-100 text-green-700 ring-2 ring-green-500'
                                            : 'bg-gray-200 text-gray-600'
                                    ]"
                                >
                                    {{ ['A', 'B', 'C', 'D'][optIndex] }}
                                </span>
                                <span :class="option === question.correct_answer ? 'text-green-700 font-medium' : 'text-gray-600'">
                                    {{ option }}
                                </span>
                            </div>
                        </div>

                        <!-- True/False Preview -->
                        <div v-if="question.question_type === 'true_false'" class="mt-3 flex items-center space-x-4 text-sm">
                            <span
                                :class="[
                                    'px-3 py-1 rounded-full',
                                    question.correct_answer === 'True'
                                        ? 'bg-green-100 text-green-700 font-medium'
                                        : 'bg-gray-100 text-gray-600'
                                ]"
                            >
                                True
                            </span>
                            <span
                                :class="[
                                    'px-3 py-1 rounded-full',
                                    question.correct_answer === 'False'
                                        ? 'bg-green-100 text-green-700 font-medium'
                                        : 'bg-gray-100 text-gray-600'
                                ]"
                            >
                                False
                            </span>
                        </div>

                        <!-- Short Answer Preview -->
                        <div v-if="question.question_type === 'short_answer'" class="mt-3 text-sm">
                            <span class="text-gray-500">Expected answer: </span>
                            <span class="text-green-700 font-medium">{{ question.correct_answer }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-1 ml-4">
                        <button
                            @click="$emit('edit', question)"
                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg"
                            title="Edit Question"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                        <button
                            @click="$emit('delete', question)"
                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg"
                            title="Delete Question"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';

export default {
    name: 'QuestionItem',
    props: {
        question: {
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
        const typeLabel = computed(() => {
            switch (props.question.question_type) {
                case 'multiple_choice':
                    return 'Multiple Choice';
                case 'true_false':
                    return 'True / False';
                case 'short_answer':
                    return 'Short Answer';
                default:
                    return props.question.question_type;
            }
        });

        const typeClass = computed(() => {
            switch (props.question.question_type) {
                case 'multiple_choice':
                    return 'bg-indigo-100 text-indigo-700';
                case 'true_false':
                    return 'bg-green-100 text-green-700';
                case 'short_answer':
                    return 'bg-purple-100 text-purple-700';
                default:
                    return 'bg-gray-100 text-gray-700';
            }
        });

        return {
            typeLabel,
            typeClass,
        };
    },
};
</script>
