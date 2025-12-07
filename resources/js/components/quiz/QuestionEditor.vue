<template>
    <div class="fixed inset-0 z-50 overflow-hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-30" @click="$emit('close')"></div>

        <!-- Slide-out Panel -->
        <div class="absolute inset-y-0 right-0 max-w-xl w-full bg-white shadow-xl flex flex-col h-full">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div :class="typeIconClass" class="flex items-center justify-center w-10 h-10 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">
                            {{ form.id ? 'Edit Question' : 'Add Question' }}
                        </h2>
                        <p class="text-sm text-gray-500">{{ typeLabel }}</p>
                    </div>
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
                    <!-- Question Text -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                        <textarea
                            v-model="form.question_text"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter your question..."
                            required
                        ></textarea>
                    </div>

                    <!-- Multiple Choice Options -->
                    <div v-if="form.question_type === 'multiple_choice'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Answer Options</label>
                        <p class="text-xs text-gray-500 mb-3">Click the radio button to mark the correct answer</p>
                        <div class="space-y-3">
                            <div
                                v-for="(option, index) in form.options"
                                :key="index"
                                class="flex items-center space-x-3"
                            >
                                <input
                                    type="radio"
                                    :checked="form.correct_answer === option && option !== ''"
                                    @change="form.correct_answer = option"
                                    :disabled="!option"
                                    class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                                >
                                <div class="flex-1 flex items-center space-x-2">
                                    <span class="w-6 h-6 bg-gray-100 text-gray-600 rounded flex items-center justify-center text-sm font-medium">
                                        {{ ['A', 'B', 'C', 'D'][index] }}
                                    </span>
                                    <input
                                        v-model="form.options[index]"
                                        type="text"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                        :placeholder="`Option ${['A', 'B', 'C', 'D'][index]}`"
                                        @input="updateCorrectAnswerIfNeeded(index)"
                                    >
                                </div>
                                <button
                                    v-if="form.options.length > 2"
                                    type="button"
                                    @click="removeOption(index)"
                                    class="p-1 text-gray-400 hover:text-red-600"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button
                            v-if="form.options.length < 6"
                            type="button"
                            @click="addOption"
                            class="mt-3 text-sm text-indigo-600 hover:text-indigo-700 font-medium"
                        >
                            + Add Option
                        </button>
                    </div>

                    <!-- True/False Options -->
                    <div v-if="form.question_type === 'true_false'">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Correct Answer</label>
                        <div class="flex space-x-4">
                            <label class="flex-1">
                                <input
                                    type="radio"
                                    v-model="form.correct_answer"
                                    value="True"
                                    class="sr-only peer"
                                >
                                <div class="w-full py-3 px-4 border-2 rounded-lg text-center cursor-pointer transition-colors peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 border-gray-200 hover:border-gray-300">
                                    <span class="font-medium">True</span>
                                </div>
                            </label>
                            <label class="flex-1">
                                <input
                                    type="radio"
                                    v-model="form.correct_answer"
                                    value="False"
                                    class="sr-only peer"
                                >
                                <div class="w-full py-3 px-4 border-2 rounded-lg text-center cursor-pointer transition-colors peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 border-gray-200 hover:border-gray-300">
                                    <span class="font-medium">False</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Short Answer -->
                    <div v-if="form.question_type === 'short_answer'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correct Answer</label>
                        <input
                            v-model="form.correct_answer"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter the expected answer..."
                            required
                        >
                        <p class="mt-1 text-xs text-gray-500">Student's answer must match exactly (case-insensitive)</p>
                    </div>

                    <!-- Explanation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Explanation (optional)</label>
                        <textarea
                            v-model="form.explanation"
                            rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Explain why this answer is correct..."
                        ></textarea>
                        <p class="mt-1 text-xs text-gray-500">Shown to students after they submit their answer</p>
                    </div>

                    <!-- Points -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
                        <input
                            v-model.number="form.points"
                            type="number"
                            min="1"
                            class="w-32 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required
                        >
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end px-6 py-4 border-t border-gray-200 bg-gray-50 space-x-3">
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
                    :disabled="!isValid"
                >
                    {{ form.id ? 'Save Changes' : 'Add Question' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, watch } from 'vue';

export default {
    name: 'QuestionEditor',
    props: {
        question: {
            type: Object,
            required: true,
        },
    },
    emits: ['close', 'save'],
    setup(props, { emit }) {
        const form = ref({
            id: props.question.id,
            question_type: props.question.question_type,
            question_text: props.question.question_text || '',
            options: props.question.options?.length ? [...props.question.options] : ['', '', '', ''],
            correct_answer: props.question.correct_answer || '',
            explanation: props.question.explanation || '',
            points: props.question.points || 1,
        });

        const typeLabel = computed(() => {
            switch (form.value.question_type) {
                case 'multiple_choice':
                    return 'Multiple Choice';
                case 'true_false':
                    return 'True / False';
                case 'short_answer':
                    return 'Short Answer';
                default:
                    return form.value.question_type;
            }
        });

        const typeIconClass = computed(() => {
            switch (form.value.question_type) {
                case 'multiple_choice':
                    return 'bg-indigo-100 text-indigo-600';
                case 'true_false':
                    return 'bg-green-100 text-green-600';
                case 'short_answer':
                    return 'bg-purple-100 text-purple-600';
                default:
                    return 'bg-gray-100 text-gray-600';
            }
        });

        const isValid = computed(() => {
            if (!form.value.question_text.trim()) return false;
            if (!form.value.correct_answer) return false;

            if (form.value.question_type === 'multiple_choice') {
                const filledOptions = form.value.options.filter(o => o.trim());
                if (filledOptions.length < 2) return false;
                if (!filledOptions.includes(form.value.correct_answer)) return false;
            }

            return true;
        });

        const addOption = () => {
            if (form.value.options.length < 6) {
                form.value.options.push('');
            }
        };

        const removeOption = (index) => {
            const removedOption = form.value.options[index];
            form.value.options.splice(index, 1);
            if (form.value.correct_answer === removedOption) {
                form.value.correct_answer = '';
            }
        };

        const updateCorrectAnswerIfNeeded = (index) => {
            // If this option was previously selected as correct but is now being changed,
            // update the correct answer to the new value
            const oldValue = props.question.options?.[index];
            if (oldValue && form.value.correct_answer === oldValue) {
                form.value.correct_answer = form.value.options[index];
            }
        };

        const save = () => {
            if (!isValid.value) return;

            // Filter out empty options for multiple choice
            const cleanedForm = { ...form.value };
            if (cleanedForm.question_type === 'multiple_choice') {
                cleanedForm.options = cleanedForm.options.filter(o => o.trim());
            }

            emit('save', cleanedForm);
        };

        watch(() => props.question, (newQuestion) => {
            form.value = {
                id: newQuestion.id,
                question_type: newQuestion.question_type,
                question_text: newQuestion.question_text || '',
                options: newQuestion.options?.length ? [...newQuestion.options] : ['', '', '', ''],
                correct_answer: newQuestion.correct_answer || '',
                explanation: newQuestion.explanation || '',
                points: newQuestion.points || 1,
            };
        }, { deep: true });

        return {
            form,
            typeLabel,
            typeIconClass,
            isValid,
            addOption,
            removeOption,
            updateCorrectAnswerIfNeeded,
            save,
        };
    },
};
</script>
