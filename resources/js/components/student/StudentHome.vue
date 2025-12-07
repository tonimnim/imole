<template>
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="flex items-center space-x-4 p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-2xl font-bold text-white">{{ userInitials }}</span>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome back, {{ userName }}!</h1>
                <p class="text-gray-500 dark:text-gray-400">Continue your learning journey</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Topics Filter (Left Sidebar) -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 sticky top-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Topics</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Filter courses by topic</p>

                    <div class="space-y-1">
                        <button
                            @click="selectedCategory = null"
                            :class="[
                                'w-full text-left px-3 py-2 rounded-lg text-sm font-medium transition-colors',
                                selectedCategory === null
                                    ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300'
                                    : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                            ]"
                        >
                            All Topics
                        </button>

                        <button
                            v-for="category in categories"
                            :key="category.id"
                            @click="selectedCategory = category.id"
                            :class="[
                                'w-full text-left px-3 py-2 rounded-lg text-sm font-medium transition-colors',
                                selectedCategory === category.id
                                    ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300'
                                    : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                            ]"
                        >
                            {{ category.name }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Courses Grid (Right Side) -->
            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ selectedCategory ? selectedCategoryName : 'All Courses' }}
                    </h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ filteredCourses.length }} course(s)
                    </span>
                </div>

                <!-- Loading State -->
                <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <div v-for="i in 6" :key="i" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden animate-pulse">
                        <div class="aspect-video bg-gray-200 dark:bg-gray-700"></div>
                        <div class="p-4 space-y-3">
                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/4"></div>
                            <div class="h-5 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/2"></div>
                        </div>
                    </div>
                </div>

                <!-- Courses Grid -->
                <div v-else-if="filteredCourses.length > 0" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <CourseCard
                        v-for="course in filteredCourses"
                        :key="course.id"
                        :course="course"
                    />
                </div>

                <!-- Empty State -->
                <div v-else class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No courses found</h3>
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ selectedCategory ? 'No courses in this topic yet. Try another topic.' : 'Check back soon for new courses!' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CourseCard from './CourseCard.vue';

export default {
    name: 'StudentHome',
    components: {
        CourseCard
    },
    props: {
        userName: {
            type: String,
            default: 'Student'
        }
    },
    data() {
        return {
            loading: true,
            categories: [],
            courses: [],
            selectedCategory: null
        };
    },
    computed: {
        userInitials() {
            return this.userName
                .split(' ')
                .map(n => n[0])
                .join('')
                .toUpperCase()
                .slice(0, 2);
        },
        selectedCategoryName() {
            const cat = this.categories.find(c => c.id === this.selectedCategory);
            return cat ? cat.name : 'All Courses';
        },
        filteredCourses() {
            if (!this.selectedCategory) {
                return this.courses;
            }
            return this.courses.filter(c => c.category?.id === this.selectedCategory);
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
            this.loading = true;
            try {
                const [categoriesRes, coursesRes] = await Promise.all([
                    fetch('/api/student/categories'),
                    fetch('/api/student/courses')
                ]);

                this.categories = await categoriesRes.json();
                this.courses = await coursesRes.json();
            } catch (error) {
                console.error('Error fetching data:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
