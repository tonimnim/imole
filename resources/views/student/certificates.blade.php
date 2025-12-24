<x-layouts.student>
    <x-slot name="title">My Certificates</x-slot>

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-yellow-500 via-yellow-600 to-orange-500">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">My Certificates</h1>
            <p class="text-yellow-100 text-lg">Your achievements and accomplishments</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        @if($certificates->count() > 0)
            <!-- Certificates Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($certificates as $certificate)
                    <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden border-2 border-yellow-200 dark:border-yellow-900/30 hover:border-yellow-400 dark:hover:border-yellow-600 hover:shadow-2xl transition-all group">
                        <!-- Certificate Header -->
                        <div class="bg-gradient-to-br from-yellow-400 via-yellow-500 to-orange-500 p-6 relative overflow-hidden">
                            <!-- Decorative Elements -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full -ml-12 -mb-12"></div>

                            <div class="relative z-10">
                                <div class="flex items-center justify-center mb-3">
                                    <div class="bg-white rounded-full p-3">
                                        <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-center text-white text-sm font-bold uppercase tracking-wider">Certificate of Completion</h3>
                            </div>
                        </div>

                        <!-- Certificate Body -->
                        <div class="p-6">
                            <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-3 line-clamp-2 min-h-[3.5rem]">
                                {{ $certificate->course->title }}
                            </h4>

                            <div class="space-y-2.5 mb-6">
                                <div class="flex items-start gap-2.5">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Certificate Number</div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $certificate->certificate_number }}</div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Issue Date</div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $certificate->issued_at->format('F d, Y') }}</div>
                                    </div>
                                </div>

                                @if($certificate->valid_until)
                                    <div class="flex items-start gap-2.5">
                                        <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Valid Until</div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $certificate->valid_until->format('F d, Y') }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2">
                                @if($certificate->file_path)
                                    <a href="{{ Storage::url($certificate->file_path) }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold rounded transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Download PDF
                                    </a>
                                @endif
                                <a href="{{ route('courses.show', $certificate->course) }}" class="flex items-center justify-center gap-2 px-4 py-2.5 border-2 border-gray-300 dark:border-gray-600 hover:border-yellow-500 dark:hover:border-yellow-500 text-gray-700 dark:text-gray-300 hover:text-yellow-600 dark:hover:text-yellow-400 text-sm font-bold rounded transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View Course
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $certificates->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 dark:bg-yellow-900/20 rounded-full mb-6">
                    <svg class="w-12 h-12 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Certificates Yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Complete courses to earn certificates and showcase your achievements</p>
                <a href="{{ route('student.my-courses') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg transition-colors">
                    View My Courses
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</x-layouts.student>
