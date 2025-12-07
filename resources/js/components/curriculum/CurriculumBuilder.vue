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
                            <h1 class="text-lg font-semibold text-gray-900">Curriculum</h1>
                            <p class="text-sm text-gray-500">{{ course.title }}</p>
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

        <!-- Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Add Section Button -->
            <button
                @click="showAddModuleModal = true"
                class="w-full mb-6 py-4 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-indigo-400 hover:text-indigo-600 transition-colors flex items-center justify-center space-x-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span class="font-medium">Add Section</span>
            </button>

            <!-- Modules List -->
            <draggable
                v-model="modules"
                item-key="id"
                handle=".module-drag-handle"
                ghost-class="opacity-50"
                @end="onModuleReorder"
                class="space-y-4"
            >
                <template #item="{ element: module, index }">
                    <ModuleItem
                        :module="module"
                        :index="index"
                        @edit="editModule"
                        @delete="deleteModule"
                        @add-lesson="addLesson"
                        @edit-lesson="editLesson"
                        @delete-lesson="deleteLesson"
                        @lessons-reordered="onLessonsReorder"
                    />
                </template>
            </draggable>

            <!-- Empty State -->
            <div v-if="modules.length === 0 && !loading" class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No sections yet</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding your first section.</p>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center py-12">
                <svg class="animate-spin h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>

        <!-- Add/Edit Module Modal -->
        <div v-if="showAddModuleModal || editingModule" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-30" @click="closeModuleModal"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        {{ editingModule ? 'Edit Section' : 'Add Section' }}
                    </h3>
                    <form @submit.prevent="saveModule">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                <input
                                    v-model="moduleForm.title"
                                    type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="e.g., Introduction"
                                    required
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description (optional)</label>
                                <textarea
                                    v-model="moduleForm.description"
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="What will students learn in this section?"
                                ></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button
                                type="button"
                                @click="closeModuleModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700"
                            >
                                {{ editingModule ? 'Save Changes' : 'Add Section' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lesson Editor Slide-out -->
        <LessonEditor
            v-if="editingLesson"
            :lesson="editingLesson"
            :module="getModuleForLesson(editingLesson)"
            @close="editingLesson = null"
            @save="saveLesson"
            @delete="confirmDeleteLesson"
        />

        <!-- Add Lesson Modal -->
        <div v-if="addingLessonToModule" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-30" @click="addingLessonToModule = null"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div
                            :class="[
                                'flex items-center justify-center w-10 h-10 rounded-lg',
                                lessonForm.type === 'video' ? 'bg-indigo-100 text-indigo-600' :
                                lessonForm.type === 'text' ? 'bg-green-100 text-green-600' :
                                lessonForm.type === 'quiz' ? 'bg-yellow-100 text-yellow-600' :
                                'bg-purple-100 text-purple-600'
                            ]"
                        >
                            <span v-html="getLessonTypeIcon(lessonForm.type)"></span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Add {{ getLessonTypeLabel(lessonForm.type) }} Lesson</h3>
                            <p class="text-sm text-gray-500">{{ addingLessonToModule.title }}</p>
                        </div>
                    </div>
                    <form @submit.prevent="createLesson">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input
                                v-model="lessonForm.title"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g., Welcome to the Course"
                                required
                                autofocus
                            >
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button
                                type="button"
                                @click="addingLessonToModule = null"
                                class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-800"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700"
                            >
                                Add Lesson
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="deleteConfirmation" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-30" @click="deleteConfirmation = null"></div>
                <div class="relative bg-white rounded-lg shadow-xl max-w-sm w-full p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete {{ deleteConfirmation.type }}?</h3>
                    <p class="text-sm text-gray-500 mb-6">
                        Are you sure you want to delete "{{ deleteConfirmation.title }}"?
                        <span v-if="deleteConfirmation.type === 'section'">This will also delete all lessons in this section.</span>
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
import { ref, onMounted } from 'vue';
import draggable from 'vuedraggable';
import ModuleItem from './ModuleItem.vue';
import LessonEditor from './LessonEditor.vue';
import axios from 'axios';

export default {
    name: 'CurriculumBuilder',
    components: {
        draggable,
        ModuleItem,
        LessonEditor,
    },
    setup() {
        const courseSlug = window.curriculumData?.courseSlug || '';
        const backUrl = window.curriculumData?.backUrl || '/teacher/courses';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
        axios.defaults.headers.common['Accept'] = 'application/json';

        const course = ref({ title: '', slug: '' });
        const modules = ref([]);
        const loading = ref(true);
        const saving = ref(false);
        const lastSaved = ref(false);

        const showAddModuleModal = ref(false);
        const editingModule = ref(null);
        const moduleForm = ref({ title: '', description: '' });

        const addingLessonToModule = ref(null);
        const editingLesson = ref(null);
        const lessonForm = ref({ title: '', type: 'video' });

        const deleteConfirmation = ref(null);

        const lessonTypes = [
            { value: 'video', label: 'Video', icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' },
            { value: 'text', label: 'Text', icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>' },
            { value: 'quiz', label: 'Quiz', icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' },
            { value: 'assignment', label: 'Assignment', icon: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>' },
        ];

        const fetchCurriculum = async () => {
            try {
                const response = await axios.get(`/api/courses/${courseSlug}/curriculum`);
                course.value = response.data.course;
                modules.value = response.data.modules;
            } catch (error) {
                console.error('Failed to fetch curriculum:', error);
            } finally {
                loading.value = false;
            }
        };

        const saveModule = async () => {
            saving.value = true;
            try {
                if (editingModule.value) {
                    const response = await axios.put(`/api/modules/${editingModule.value.id}`, moduleForm.value);
                    const index = modules.value.findIndex(m => m.id === editingModule.value.id);
                    if (index !== -1) {
                        modules.value[index] = { ...modules.value[index], ...response.data };
                    }
                } else {
                    const response = await axios.post(`/api/courses/${courseSlug}/modules`, moduleForm.value);
                    modules.value.push(response.data);
                }
                closeModuleModal();
                showSavedIndicator();
            } catch (error) {
                console.error('Failed to save module:', error);
            } finally {
                saving.value = false;
            }
        };

        const closeModuleModal = () => {
            showAddModuleModal.value = false;
            editingModule.value = null;
            moduleForm.value = { title: '', description: '' };
        };

        const editModule = (module) => {
            editingModule.value = module;
            moduleForm.value = { title: module.title, description: module.description || '' };
        };

        const deleteModule = (module) => {
            deleteConfirmation.value = {
                type: 'section',
                id: module.id,
                title: module.title,
                callback: async () => {
                    saving.value = true;
                    try {
                        await axios.delete(`/api/modules/${module.id}`);
                        modules.value = modules.value.filter(m => m.id !== module.id);
                        showSavedIndicator();
                    } catch (error) {
                        console.error('Failed to delete module:', error);
                    } finally {
                        saving.value = false;
                    }
                }
            };
        };

        const addLesson = (module, type) => {
            addingLessonToModule.value = module;
            lessonForm.value = { title: '', type: type || 'video' };
        };

        const createLesson = async () => {
            saving.value = true;
            try {
                const response = await axios.post(`/api/modules/${addingLessonToModule.value.id}/lessons`, lessonForm.value);
                const moduleIndex = modules.value.findIndex(m => m.id === addingLessonToModule.value.id);
                if (moduleIndex !== -1) {
                    if (!modules.value[moduleIndex].lessons) {
                        modules.value[moduleIndex].lessons = [];
                    }
                    modules.value[moduleIndex].lessons.push(response.data);
                }
                addingLessonToModule.value = null;
                lessonForm.value = { title: '', type: 'video' };
                showSavedIndicator();
            } catch (error) {
                console.error('Failed to create lesson:', error);
            } finally {
                saving.value = false;
            }
        };

        const editLesson = (lesson) => {
            editingLesson.value = { ...lesson };
        };

        const saveLesson = async (lessonData) => {
            saving.value = true;
            try {
                const response = await axios.put(`/api/lessons/${lessonData.id}`, lessonData);
                for (const module of modules.value) {
                    const lessonIndex = module.lessons?.findIndex(l => l.id === lessonData.id);
                    if (lessonIndex !== undefined && lessonIndex !== -1) {
                        module.lessons[lessonIndex] = response.data;
                        break;
                    }
                }
                editingLesson.value = null;
                showSavedIndicator();
            } catch (error) {
                console.error('Failed to save lesson:', error);
            } finally {
                saving.value = false;
            }
        };

        const deleteLesson = (lesson) => {
            deleteConfirmation.value = {
                type: 'lesson',
                id: lesson.id,
                title: lesson.title,
                callback: async () => {
                    saving.value = true;
                    try {
                        await axios.delete(`/api/lessons/${lesson.id}`);
                        for (const module of modules.value) {
                            module.lessons = module.lessons?.filter(l => l.id !== lesson.id);
                        }
                        showSavedIndicator();
                    } catch (error) {
                        console.error('Failed to delete lesson:', error);
                    } finally {
                        saving.value = false;
                    }
                }
            };
        };

        const confirmDeleteLesson = (lesson) => {
            editingLesson.value = null;
            deleteLesson(lesson);
        };

        const confirmDelete = () => {
            if (deleteConfirmation.value?.callback) {
                deleteConfirmation.value.callback();
            }
            deleteConfirmation.value = null;
        };

        const getModuleForLesson = (lesson) => {
            return modules.value.find(m => m.lessons?.some(l => l.id === lesson.id));
        };

        const getLessonTypeIcon = (type) => {
            const found = lessonTypes.find(t => t.value === type);
            return found?.icon || '';
        };

        const getLessonTypeLabel = (type) => {
            const found = lessonTypes.find(t => t.value === type);
            return found?.label || 'Lesson';
        };

        const onModuleReorder = async () => {
            await saveOrder();
        };

        const onLessonsReorder = async (moduleId, lessons) => {
            const moduleIndex = modules.value.findIndex(m => m.id === moduleId);
            if (moduleIndex !== -1) {
                modules.value[moduleIndex].lessons = lessons;
            }
            await saveOrder();
        };

        const saveOrder = async () => {
            saving.value = true;
            try {
                const orderData = modules.value.map((module, moduleIndex) => ({
                    id: module.id,
                    order: moduleIndex + 1,
                    lessons: module.lessons?.map((lesson, lessonIndex) => ({
                        id: lesson.id,
                        order: lessonIndex + 1,
                    })) || [],
                }));
                await axios.post(`/api/courses/${courseSlug}/curriculum/reorder`, { modules: orderData });
                showSavedIndicator();
            } catch (error) {
                console.error('Failed to save order:', error);
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
            fetchCurriculum();
        });

        return {
            course,
            modules,
            loading,
            saving,
            lastSaved,
            backUrl,
            showAddModuleModal,
            editingModule,
            moduleForm,
            addingLessonToModule,
            editingLesson,
            lessonForm,
            lessonTypes,
            deleteConfirmation,
            saveModule,
            closeModuleModal,
            editModule,
            deleteModule,
            addLesson,
            createLesson,
            editLesson,
            saveLesson,
            deleteLesson,
            confirmDeleteLesson,
            confirmDelete,
            getModuleForLesson,
            getLessonTypeIcon,
            getLessonTypeLabel,
            onModuleReorder,
            onLessonsReorder,
        };
    },
};
</script>
