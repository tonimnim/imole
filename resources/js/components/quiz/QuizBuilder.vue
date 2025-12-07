<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 sticky top-0 z-40">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <a :href="backUrl" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-lg font-semibold text-gray-900">Quiz Builder</h1>
                            <p class="text-sm text-gray-500" v-if="currentQuiz">{{ currentQuiz.title }}</p>
                            <p class="text-sm text-gray-500" v-else>Create and manage quizzes</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span v-if="saving" class="flex items-center text-sm text-gray-500">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Saving...
                        </span>
                        <span v-else-if="lastSaved" class="text-sm text-green-600">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Saved
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Quiz List View -->
            <div v-if="!currentQuiz && !showCreateForm">
                <!-- Create New Quiz Button -->
                <button
                    @click="showCreateForm = true"
                    class="w-full mb-6 py-4 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-indigo-400 hover:text-indigo-600 transition-colors flex items-center justify-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span class="font-medium">Create New Quiz</span>
                </button>

                <!-- Quizzes List -->
                <div v-if="quizzes.length > 0" class="space-y-4">
                    <div
                        v-for="quiz in quizzes"
                        :key="quiz.id"
                        class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow cursor-pointer"
                        @click="openQuiz(quiz)"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="font-semibold text-gray-900">{{ quiz.title }}</h3>
                                    <span
                                        :class="[
                                            'px-2 py-0.5 text-xs font-medium rounded-full',
                                            quiz.is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'
                                        ]"
                                    >
                                        {{ quiz.is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ quiz.course?.title }} &bull; {{ quiz.lesson?.title }}</p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ quiz.questions_count || 0 }} questions
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ quiz.duration_minutes || 'No' }} min
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ quiz.passing_score }}% to pass
                                    </span>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else-if="!loading" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No quizzes yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first quiz.</p>
                </div>
            </div>

            <!-- Create Quiz Form -->
            <div v-if="showCreateForm && !currentQuiz" class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Create New Quiz</h2>
                <form @submit.prevent="createQuiz" class="space-y-6">
                    <!-- Course Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                        <select
                            v-model="newQuizForm.course_id"
                            @change="loadQuizLessons"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required
                        >
                            <option value="">Select a course</option>
                            <option v-for="course in courses" :key="course.id" :value="course.id">
                                {{ course.title }}
                            </option>
                        </select>
                    </div>

                    <!-- Lesson Selection (Quiz type only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quiz Lesson</label>
                        <select
                            v-model="newQuizForm.lesson_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required
                            :disabled="!newQuizForm.course_id"
                        >
                            <option value="">Select a quiz lesson</option>
                            <option v-for="lesson in quizLessons" :key="lesson.id" :value="lesson.id">
                                {{ lesson.module?.title }} &bull; {{ lesson.title }}
                            </option>
                        </select>
                        <p v-if="newQuizForm.course_id && quizLessons.length === 0" class="mt-1 text-sm text-amber-600">
                            No quiz lessons found. Create a quiz-type lesson in the curriculum first.
                        </p>
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quiz Title</label>
                        <input
                            v-model="newQuizForm.title"
                            type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="e.g., Module 1 Assessment"
                            required
                        >
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                        <textarea
                            v-model="newQuizForm.description"
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Describe what this quiz covers..."
                        ></textarea>
                    </div>

                    <!-- Settings Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                            <input
                                v-model.number="newQuizForm.duration_minutes"
                                type="number"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Optional"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Passing Score (%)</label>
                            <input
                                v-model.number="newQuizForm.passing_score"
                                type="number"
                                min="0"
                                max="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Attempts</label>
                            <input
                                v-model.number="newQuizForm.max_attempts"
                                type="number"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required
                            >
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button
                            type="button"
                            @click="showCreateForm = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700"
                            :disabled="!newQuizForm.lesson_id"
                        >
                            Create Quiz
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quiz Editor View -->
            <div v-if="currentQuiz">
                <!-- Back to list -->
                <button
                    @click="closeQuiz"
                    class="flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to quizzes
                </button>

                <!-- Quiz Settings Card -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                    <div class="flex items-start justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Quiz Settings</h2>
                        <button
                            @click="deleteQuiz"
                            class="text-red-600 hover:text-red-700 text-sm font-medium"
                        >
                            Delete Quiz
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input
                                v-model="currentQuiz.title"
                                @blur="updateQuiz"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration (min)</label>
                            <input
                                v-model.number="currentQuiz.duration_minutes"
                                @blur="updateQuiz"
                                type="number"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Passing Score (%)</label>
                            <input
                                v-model.number="currentQuiz.passing_score"
                                @blur="updateQuiz"
                                type="number"
                                min="0"
                                max="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Attempts</label>
                            <input
                                v-model.number="currentQuiz.max_attempts"
                                @blur="updateQuiz"
                                type="number"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                        </div>
                    </div>
                    <div class="flex items-center space-x-6 mt-4 pt-4 border-t border-gray-100">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input
                                v-model="currentQuiz.shuffle_questions"
                                @change="updateQuiz"
                                type="checkbox"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                            >
                            <span class="text-sm text-gray-700">Shuffle questions</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input
                                v-model="currentQuiz.show_correct_answers"
                                @change="updateQuiz"
                                type="checkbox"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                            >
                            <span class="text-sm text-gray-700">Show correct answers after submission</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input
                                v-model="currentQuiz.is_published"
                                @change="updateQuiz"
                                type="checkbox"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                            >
                            <span class="text-sm text-gray-700">Published</span>
                        </label>
                    </div>
                </div>

                <!-- Questions Section -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Questions</h2>
                            <span class="text-sm text-gray-500">{{ currentQuiz.questions?.length || 0 }} questions &bull; {{ totalPoints }} points</span>
                        </div>
                    </div>

                    <!-- Questions List -->
                    <div class="p-4">
                        <draggable
                            v-model="currentQuiz.questions"
                            item-key="id"
                            handle=".question-drag-handle"
                            ghost-class="opacity-50"
                            @end="onQuestionsReorder"
                            class="space-y-3"
                        >
                            <template #item="{ element: question, index }">
                                <QuestionItem
                                    :question="question"
                                    :index="index"
                                    @edit="editQuestion"
                                    @delete="deleteQuestion"
                                />
                            </template>
                        </draggable>

                        <!-- Empty State -->
                        <div v-if="!currentQuiz.questions?.length" class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-10 w-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm">No questions yet. Add your first question below.</p>
                        </div>

                        <!-- Add Question Buttons -->
                        <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                            <button
                                @click="addQuestion('multiple_choice')"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                            >
                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Multiple Choice
                            </button>
                            <button
                                @click="addQuestion('true_false')"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                            >
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                True / False
                            </button>
                            <button
                                @click="addQuestion('short_answer')"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                            >
                                <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Short Answer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center py-12">
                <svg class="animate-spin h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>

        <!-- Question Editor Modal -->
        <QuestionEditor
            v-if="editingQuestion"
            :question="editingQuestion"
            @close="editingQuestion = null"
            @save="saveQuestion"
        />

        <!-- Delete Confirmation Modal -->
        <div v-if="deleteConfirmation" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-30" @click="deleteConfirmation = null"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-sm w-full p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete {{ deleteConfirmation.type }}?</h3>
                    <p class="text-sm text-gray-500 mb-6">
                        Are you sure you want to delete this {{ deleteConfirmation.type }}?
                        <span v-if="deleteConfirmation.type === 'quiz'">This will also delete all questions.</span>
                        This action cannot be undone.
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button
                            @click="deleteConfirmation = null"
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800"
                        >
                            Cancel
                        </button>
                        <button
                            @click="confirmDelete"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import draggable from 'vuedraggable';
import QuestionItem from './QuestionItem.vue';
import QuestionEditor from './QuestionEditor.vue';
import axios from 'axios';

export default {
    name: 'QuizBuilder',
    components: {
        draggable,
        QuestionItem,
        QuestionEditor,
    },
    setup() {
        const backUrl = window.quizBuilderData?.backUrl || '/teacher/quizzes';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
        axios.defaults.headers.common['Accept'] = 'application/json';

        const quizzes = ref([]);
        const courses = ref([]);
        const quizLessons = ref([]);
        const currentQuiz = ref(null);
        const loading = ref(true);
        const saving = ref(false);
        const lastSaved = ref(false);
        const showCreateForm = ref(false);
        const editingQuestion = ref(null);
        const deleteConfirmation = ref(null);

        const newQuizForm = ref({
            course_id: '',
            lesson_id: '',
            title: '',
            description: '',
            duration_minutes: null,
            passing_score: 70,
            max_attempts: 3,
        });

        const totalPoints = computed(() => {
            if (!currentQuiz.value?.questions) return 0;
            return currentQuiz.value.questions.reduce((sum, q) => sum + (q.points || 0), 0);
        });

        const fetchQuizzes = async () => {
            try {
                const response = await axios.get('/api/quizzes');
                quizzes.value = response.data;
            } catch (error) {
                console.error('Failed to fetch quizzes:', error);
            } finally {
                loading.value = false;
            }
        };

        const fetchCourses = async () => {
            try {
                const response = await axios.get('/api/teacher/courses');
                courses.value = response.data;
            } catch (error) {
                console.error('Failed to fetch courses:', error);
            }
        };

        const loadQuizLessons = async () => {
            if (!newQuizForm.value.course_id) {
                quizLessons.value = [];
                return;
            }
            try {
                const course = courses.value.find(c => c.id === newQuizForm.value.course_id);
                const response = await axios.get(`/api/courses/${course.slug}/quiz-lessons`);
                quizLessons.value = response.data;
                newQuizForm.value.lesson_id = '';
            } catch (error) {
                console.error('Failed to fetch quiz lessons:', error);
            }
        };

        const createQuiz = async () => {
            saving.value = true;
            try {
                const response = await axios.post('/api/quizzes', newQuizForm.value);
                quizzes.value.unshift(response.data);
                currentQuiz.value = response.data;
                showCreateForm.value = false;
                newQuizForm.value = {
                    course_id: '',
                    lesson_id: '',
                    title: '',
                    description: '',
                    duration_minutes: null,
                    passing_score: 70,
                    max_attempts: 3,
                };
                showSavedIndicator();
            } catch (error) {
                console.error('Failed to create quiz:', error);
            } finally {
                saving.value = false;
            }
        };

        const openQuiz = async (quiz) => {
            loading.value = true;
            try {
                const response = await axios.get(`/api/quizzes/${quiz.id}`);
                currentQuiz.value = response.data;
            } catch (error) {
                console.error('Failed to load quiz:', error);
            } finally {
                loading.value = false;
            }
        };

        const closeQuiz = () => {
            currentQuiz.value = null;
            fetchQuizzes();
        };

        const updateQuiz = async () => {
            if (!currentQuiz.value) return;
            saving.value = true;
            try {
                await axios.put(`/api/quizzes/${currentQuiz.value.id}`, {
                    title: currentQuiz.value.title,
                    description: currentQuiz.value.description,
                    duration_minutes: currentQuiz.value.duration_minutes,
                    passing_score: currentQuiz.value.passing_score,
                    max_attempts: currentQuiz.value.max_attempts,
                    shuffle_questions: currentQuiz.value.shuffle_questions,
                    show_correct_answers: currentQuiz.value.show_correct_answers,
                    is_published: currentQuiz.value.is_published,
                });
                showSavedIndicator();
            } catch (error) {
                console.error('Failed to update quiz:', error);
            } finally {
                saving.value = false;
            }
        };

        const deleteQuiz = () => {
            deleteConfirmation.value = {
                type: 'quiz',
                callback: async () => {
                    saving.value = true;
                    try {
                        await axios.delete(`/api/quizzes/${currentQuiz.value.id}`);
                        quizzes.value = quizzes.value.filter(q => q.id !== currentQuiz.value.id);
                        currentQuiz.value = null;
                    } catch (error) {
                        console.error('Failed to delete quiz:', error);
                    } finally {
                        saving.value = false;
                    }
                }
            };
        };

        const addQuestion = (type) => {
            editingQuestion.value = {
                id: null,
                question_type: type,
                question_text: '',
                options: type === 'multiple_choice' ? ['', '', '', ''] : (type === 'true_false' ? ['True', 'False'] : []),
                correct_answer: type === 'true_false' ? 'True' : '',
                explanation: '',
                points: 1,
            };
        };

        const editQuestion = (question) => {
            editingQuestion.value = { ...question };
        };

        const saveQuestion = async (questionData) => {
            saving.value = true;
            try {
                if (questionData.id) {
                    const response = await axios.put(`/api/questions/${questionData.id}`, questionData);
                    const index = currentQuiz.value.questions.findIndex(q => q.id === questionData.id);
                    if (index !== -1) {
                        currentQuiz.value.questions[index] = response.data;
                    }
                } else {
                    const response = await axios.post(`/api/quizzes/${currentQuiz.value.id}/questions`, questionData);
                    if (!currentQuiz.value.questions) {
                        currentQuiz.value.questions = [];
                    }
                    currentQuiz.value.questions.push(response.data);
                }
                editingQuestion.value = null;
                showSavedIndicator();
            } catch (error) {
                console.error('Failed to save question:', error);
            } finally {
                saving.value = false;
            }
        };

        const deleteQuestion = (question) => {
            deleteConfirmation.value = {
                type: 'question',
                callback: async () => {
                    saving.value = true;
                    try {
                        await axios.delete(`/api/questions/${question.id}`);
                        currentQuiz.value.questions = currentQuiz.value.questions.filter(q => q.id !== question.id);
                        showSavedIndicator();
                    } catch (error) {
                        console.error('Failed to delete question:', error);
                    } finally {
                        saving.value = false;
                    }
                }
            };
        };

        const confirmDelete = () => {
            if (deleteConfirmation.value?.callback) {
                deleteConfirmation.value.callback();
            }
            deleteConfirmation.value = null;
        };

        const onQuestionsReorder = async () => {
            saving.value = true;
            try {
                const orderData = currentQuiz.value.questions.map((q, index) => ({
                    id: q.id,
                    order: index + 1,
                }));
                await axios.post(`/api/quizzes/${currentQuiz.value.id}/questions/reorder`, { questions: orderData });
                showSavedIndicator();
            } catch (error) {
                console.error('Failed to reorder questions:', error);
            } finally {
                saving.value = false;
            }
        };

        const showSavedIndicator = () => {
            lastSaved.value = true;
            setTimeout(() => {
                lastSaved.value = false;
            }, 2000);
        };

        onMounted(() => {
            fetchQuizzes();
            fetchCourses();
        });

        return {
            backUrl,
            quizzes,
            courses,
            quizLessons,
            currentQuiz,
            loading,
            saving,
            lastSaved,
            showCreateForm,
            newQuizForm,
            editingQuestion,
            deleteConfirmation,
            totalPoints,
            loadQuizLessons,
            createQuiz,
            openQuiz,
            closeQuiz,
            updateQuiz,
            deleteQuiz,
            addQuestion,
            editQuestion,
            saveQuestion,
            deleteQuestion,
            confirmDelete,
            onQuestionsReorder,
        };
    },
};
</script>
