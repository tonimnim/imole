<template>
    <a :href="courseUrl" class="group block">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-200 hover:-translate-y-1">
            <!-- Course Thumbnail -->
            <div class="aspect-video relative overflow-hidden">
                <div v-if="course.thumbnail" class="w-full h-full">
                    <img
                        :src="course.thumbnail"
                        :alt="course.title"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                    />
                </div>
                <div v-else class="w-full h-full bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>

                <!-- Level Badge -->
                <div class="absolute top-3 right-3">
                    <span :class="levelBadgeClass">
                        {{ levelLabel }}
                    </span>
                </div>
            </div>

            <!-- Course Info -->
            <div class="p-4">
                <!-- Category Badge -->
                <div v-if="course.category" class="mb-2">
                    <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700">
                        {{ course.category.name }}
                    </span>
                </div>

                <!-- Title -->
                <h3 class="font-semibold text-gray-900 group-hover:text-green-600 line-clamp-2 mb-2 min-h-[48px]">
                    {{ course.title }}
                </h3>

                <!-- Instructor -->
                <p v-if="course.instructor" class="text-sm text-gray-500 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ course.instructor.name }}
                </p>

                <!-- Stats -->
                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ course.lessons_count }} {{ course.lessons_count === 1 ? 'lesson' : 'lessons' }}
                    </span>
                </div>

                <!-- Price -->
                <div class="pt-3 border-t border-gray-100">
                    <span v-if="course.price > 0" class="text-lg font-bold text-gray-900">
                        ${{ formatPrice(course.price) }}
                    </span>
                    <span v-else class="text-lg font-bold text-green-600">
                        Free
                    </span>
                </div>
            </div>
        </div>
    </a>
</template>

<script>
export default {
    name: 'CourseCard',
    props: {
        course: {
            type: Object,
            required: true
        }
    },
    computed: {
        courseUrl() {
            return `/courses/${this.course.slug || this.course.id}`;
        },
        levelLabel() {
            const levels = {
                beginner: 'Beginner',
                intermediate: 'Intermediate',
                advanced: 'Advanced'
            };
            return levels[this.course.level] || 'Beginner';
        },
        levelBadgeClass() {
            const base = 'px-2 py-1 text-xs font-medium rounded-full';
            const colors = {
                beginner: 'bg-green-100 text-green-700',
                intermediate: 'bg-yellow-100 text-yellow-700',
                advanced: 'bg-red-100 text-red-700'
            };
            return `${base} ${colors[this.course.level] || colors.beginner}`;
        }
    },
    methods: {
        formatPrice(price) {
            return Number(price).toFixed(2);
        }
    }
};
</script>
