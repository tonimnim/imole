<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $lesson->title }} - {{ $course->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }
        #completion-modal {
            transition: opacity 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gray-950 text-white">
    <!-- Course Completion Modal -->
    @if(session('course_completed'))
        <div id="completion-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
            <div class="bg-gray-900 rounded-2xl max-w-lg w-full p-8 relative animate-scale-in border border-purple-600">
                <!-- Close Button -->
                <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Modal Content -->
                <div class="text-center">
                    <!-- Trophy Icon -->
                    <div class="w-24 h-24 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>

                    <!-- Text -->
                    <h2 class="text-3xl font-bold mb-3 bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                        Congratulations! 🎉
                    </h2>
                    <p class="text-xl text-white mb-2">You've completed</p>
                    <p class="text-lg font-bold text-purple-400 mb-6">{{ $course->title }}</p>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('student.learn.completed', $course) }}" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold rounded-lg transition">
                            View Achievement
                        </a>
                        <button onclick="closeModal()" class="flex-1 px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-medium rounded-lg transition border border-gray-700">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Top Navigation -->
    <nav class="bg-gray-900 border-b border-gray-800 sticky top-0 z-50">
        <div class="flex items-center justify-between h-16 px-4">
            <!-- Left: Menu Toggle & Course Title -->
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <button id="sidebar-toggle" class="p-2 hover:bg-gray-800 rounded-lg transition lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <a href="{{ route('student.my-courses') }}" class="p-2 hover:bg-gray-800 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
                <h1 class="text-sm font-semibold truncate">{{ $course->title }}</h1>
            </div>

            <!-- Right: Progress -->
            <div class="hidden md:flex items-center gap-3">
                <span class="text-sm text-gray-400">{{ $progressPercentage }}%</span>
                <div class="w-24 h-2 bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-600 transition-all" style="width: {{ $progressPercentage }}%"></div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-40 w-80 bg-gray-900 border-r border-gray-800 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 overflow-y-auto" style="top: 64px;">
            <div class="p-4">
                <h2 class="text-lg font-bold mb-4">Course Content</h2>

                @foreach($modules as $module)
                    <div class="mb-2">
                        <button onclick="toggleModule({{ $module->id }})" class="w-full flex items-center justify-between p-3 bg-gray-800 hover:bg-gray-750 rounded-lg transition">
                            <div class="flex items-center gap-2">
                                <svg id="icon-{{ $module->id }}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $module->title }}</span>
                            </div>
                            <span class="text-xs text-gray-500">{{ $module->lessons->count() }}</span>
                        </button>
                        <div id="module-{{ $module->id }}" class="hidden mt-1 ml-4 space-y-1">
                            @foreach($module->lessons as $moduleLesson)
                                <a href="{{ route('student.learn.lesson', ['course' => $course->slug, 'lesson' => $moduleLesson->slug]) }}"
                                   class="flex items-center gap-2 p-2 rounded {{ $moduleLesson->id === $lesson->id ? 'bg-purple-600/20 border-l-2 border-purple-600' : 'hover:bg-gray-800' }} transition">
                                    @if(in_array($moduleLesson->id, $completedLessonIds))
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-600"></div>
                                    @endif
                                    <span class="text-sm flex-1 {{ $moduleLesson->id === $lesson->id ? 'text-purple-400 font-medium' : 'text-gray-300' }}">
                                        {{ $moduleLesson->title }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $moduleLesson->duration_minutes }}m</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 lg:hidden hidden" onclick="closeSidebar()"></div>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
            <!-- Video Player -->
            @if($lesson->video_url)
                <div class="bg-black aspect-video">
                    @if($lesson->video_provider === 'youtube')
                        @php
                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?]+)/', $lesson->video_url, $matches);
                            $youtubeId = $matches[1] ?? '';
                        @endphp
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}?start={{ $lessonProgress->last_position_seconds ?? 0 }}" frameborder="0" allowfullscreen></iframe>
                    @elseif($lesson->video_provider === 'vimeo')
                        @php
                            preg_match('/vimeo\.com\/([0-9]+)/', $lesson->video_url, $matches);
                            $vimeoId = $matches[1] ?? '';
                        @endphp
                        <iframe class="w-full h-full" src="https://player.vimeo.com/video/{{ $vimeoId }}" frameborder="0" allowfullscreen></iframe>
                    @else
                        <video class="w-full h-full" controls>
                            <source src="{{ $lesson->video_url }}" type="video/mp4">
                        </video>
                    @endif
                </div>
            @endif

            <!-- Content Area -->
            <div class="p-6 max-w-5xl mx-auto">
                <!-- Lesson Title -->
                <h1 class="text-3xl font-bold mb-4">{{ $lesson->title }}</h1>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 mb-6">
                    @if(!$lessonProgress->is_completed)
                        <form action="{{ route('student.learn.complete', ['course' => $course->slug, 'lesson' => $lesson->slug]) }}" method="POST" id="complete-form">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 rounded-lg font-medium transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Mark as Complete</span>
                                <svg class="w-5 h-5 hidden animate-spin" id="complete-spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </button>
                        </form>
                    @else
                        <div class="px-6 py-3 bg-green-600/20 text-green-400 rounded-lg font-medium border border-green-600/50 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Completed</span>
                        </div>
                    @endif

                    @if($previousLesson)
                        <a href="{{ route('student.learn.lesson', ['course' => $course->slug, 'lesson' => $previousLesson->slug]) }}" class="px-6 py-3 bg-gray-800 hover:bg-gray-700 rounded-lg font-medium transition">
                            ← Previous
                        </a>
                    @endif

                    @if($nextLesson)
                        <a href="{{ route('student.learn.lesson', ['course' => $course->slug, 'lesson' => $nextLesson->slug]) }}" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 rounded-lg font-medium transition">
                            Next Lesson →
                        </a>
                    @endif
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-800 mb-6">
                    <nav class="flex gap-6 overflow-x-auto">
                        <button onclick="showTab('overview')" class="tab-button border-b-2 border-purple-600 text-purple-400 py-3 px-1 font-medium whitespace-nowrap">
                            Overview
                        </button>
                        @if($lesson->resources->count() > 0)
                            <button onclick="showTab('resources')" class="tab-button border-b-2 border-transparent text-gray-400 hover:text-white py-3 px-1 font-medium whitespace-nowrap">
                                Resources ({{ $lesson->resources->count() }})
                            </button>
                        @endif
                        <button onclick="showTab('notes')" class="tab-button border-b-2 border-transparent text-gray-400 hover:text-white py-3 px-1 font-medium whitespace-nowrap">
                            Notes ({{ $notes->count() }})
                        </button>
                        @if($quiz)
                            <button onclick="showTab('quiz')" class="tab-button border-b-2 border-transparent text-gray-400 hover:text-white py-3 px-1 font-medium whitespace-nowrap">
                                Quiz
                            </button>
                        @endif
                        <button onclick="showTab('qa')" class="tab-button border-b-2 border-transparent text-gray-400 hover:text-white py-3 px-1 font-medium whitespace-nowrap">
                            Q&A ({{ $lesson->comments->count() }})
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div id="tab-content">
                    <!-- Overview -->
                    <div id="overview-tab" class="tab-pane">
                        <div class="prose prose-invert max-w-none">
                            {!! $lesson->content !!}
                        </div>
                    </div>

                    <!-- Resources -->
                    @if($lesson->resources->count() > 0)
                        <div id="resources-tab" class="tab-pane hidden">
                            <div class="space-y-3">
                                @foreach($lesson->resources as $resource)
                                    <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            <div>
                                                <h4 class="font-medium">{{ $resource->title }}</h4>
                                                <p class="text-sm text-gray-400">{{ strtoupper($resource->file_type) }} • {{ number_format($resource->file_size / 1024 / 1024, 2) }} MB</p>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . $resource->file_path) }}" download class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg transition">
                                            Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Notes -->
                    <div id="notes-tab" class="tab-pane hidden">
                        <form id="note-form" class="mb-6 p-4 bg-gray-800 rounded-lg">
                            @csrf
                            <textarea id="note-content" rows="4" class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Take a note..."></textarea>
                            <div class="flex items-center justify-between mt-3">
                                <label class="flex items-center text-sm text-gray-400">
                                    <input type="checkbox" id="note-timestamp" class="mr-2 rounded">
                                    Save video timestamp
                                </label>
                                <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg font-medium transition">
                                    Save Note
                                </button>
                            </div>
                        </form>

                        <div class="space-y-3">
                            @forelse($notes as $note)
                                <div class="p-4 bg-gray-800 rounded-lg" data-note-id="{{ $note->id }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            @if($note->video_timestamp)
                                                <button class="text-xs text-purple-400 mb-1">
                                                    🕒 {{ $note->formatted_timestamp }}
                                                </button>
                                            @endif
                                            <p class="text-white">{{ $note->content }}</p>
                                        </div>
                                        <button onclick="deleteNote({{ $note->id }})" class="ml-4 text-gray-400 hover:text-red-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $note->created_at->diffForHumans() }}</p>
                                </div>
                            @empty
                                <div class="text-center py-12 text-gray-400">
                                    <p>No notes yet. Start taking notes!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quiz -->
                    @if($quiz)
                        <div id="quiz-tab" class="tab-pane hidden">
                            <div class="p-6 bg-gradient-to-r from-purple-900/30 to-indigo-900/30 border border-purple-700/50 rounded-lg mb-6">
                                <h3 class="text-2xl font-bold mb-2">{{ $quiz->title }}</h3>
                                <p class="text-gray-300 mb-4">{{ $quiz->description }}</p>
                                <div class="flex gap-6 text-sm">
                                    <div>📝 {{ $quiz->questions->count() }} Questions</div>
                                    <div>⏱️ {{ $quiz->duration_minutes }} Minutes</div>
                                    <div>✓ {{ $quiz->passing_score }}% to Pass</div>
                                </div>
                            </div>
                            <a href="#" class="inline-block px-8 py-3 bg-purple-600 hover:bg-purple-700 rounded-lg font-bold transition">
                                Start Quiz
                            </a>
                        </div>
                    @endif

                    <!-- Q&A -->
                    <div id="qa-tab" class="tab-pane hidden">
                        <div class="space-y-6">
                            @forelse($lesson->comments as $comment)
                                <div class="border-b border-gray-800 pb-6">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center font-bold">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="font-medium">{{ $comment->user->name }}</span>
                                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-gray-300">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 text-gray-400">
                                    <p>No questions yet. Be the first to ask!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Close Completion Modal
        function closeModal() {
            const modal = document.getElementById('completion-modal');
            if (modal) {
                modal.classList.add('opacity-0');
                setTimeout(() => modal.remove(), 300);
            }
        }

        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        }

        // Mark as Complete - Show loading state
        document.getElementById('complete-form')?.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            const spinner = document.getElementById('complete-spinner');
            button.disabled = true;
            button.classList.add('opacity-75');
            spinner?.classList.remove('hidden');
        });

        // Module Toggle
        function toggleModule(moduleId) {
            const content = document.getElementById('module-' + moduleId);
            const icon = document.getElementById('icon-' + moduleId);

            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-90');
        }

        // Auto-open current lesson's module
        @foreach($modules as $module)
            @if($module->lessons->contains('id', $lesson->id))
                toggleModule({{ $module->id }});
            @endif
        @endforeach

        // Tab Switching
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.add('hidden'));

            // Remove active state from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('border-purple-600', 'text-purple-400');
                btn.classList.add('border-transparent', 'text-gray-400');
            });

            // Show selected tab
            const tab = document.getElementById(tabName + '-tab');
            if (tab) {
                tab.classList.remove('hidden');
            }

            // Activate clicked button
            event.target.classList.remove('border-transparent', 'text-gray-400');
            event.target.classList.add('border-purple-600', 'text-purple-400');
        }

        // Notes Form
        document.getElementById('note-form')?.addEventListener('submit', async function(e) {
            e.preventDefault();

            const content = document.getElementById('note-content').value;
            if (!content.trim()) return;

            const timestamp = document.getElementById('note-timestamp').checked ? 0 : null;

            try {
                const response = await fetch('{{ route("student.learn.notes.save", ["course" => $course->slug, "lesson" => $lesson->slug]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        content: content,
                        video_timestamp: timestamp
                    })
                });

                if (response.ok) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });

        // Delete Note
        async function deleteNote(noteId) {
            if (!confirm('Delete this note?')) return;

            try {
                const response = await fetch(`/learn/{{ $course->slug }}/{{ $lesson->slug }}/notes/${noteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    document.querySelector(`[data-note-id="${noteId}"]`).remove();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
</body>
</html>
