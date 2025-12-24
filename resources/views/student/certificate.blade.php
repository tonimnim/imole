<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion - {{ $certificate->course->title }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .certificate-container { box-shadow: none; }
        }
        @page { size: landscape; margin: 0; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Action Buttons (No Print) -->
    <div class="no-print fixed top-4 right-4 z-50 flex gap-3">
        <a href="{{ route('certificate.download', $certificate) }}" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium shadow-lg transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download PDF
        </a>
        <a href="{{ route('student.learn.completed', $certificate->course) }}" class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-lg font-medium shadow-lg transition">
            Back to Course
        </a>
    </div>

    <!-- Certificate -->
    <div class="min-h-screen flex items-center justify-center p-8">
        <div class="certificate-container bg-gradient-to-br from-gray-50 to-purple-50 rounded-2xl shadow-2xl" style="width: 1056px; height: 816px; position: relative;">
            <!-- Decorative Border -->
            <div class="absolute inset-4 border-4 border-purple-600 rounded-xl" style="border-image: linear-gradient(135deg, #9333ea, #ec4899) 1;">
                <div class="absolute inset-2 border-2 border-purple-400/50 rounded-lg"></div>
            </div>

            <!-- Content -->
            <div class="relative h-full flex flex-col items-center justify-between p-16">
                <!-- Header with Logo -->
                <div class="text-center">
                    <!-- Logo/Brand -->
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full mb-4 shadow-lg">
                            <span class="text-5xl font-bold text-white">IA</span>
                        </div>
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            imole Africa
                        </h3>
                        <p class="text-gray-600 text-sm">Learning Management System</p>
                    </div>
                </div>

                <!-- Certificate Title -->
                <div class="text-center -mt-8">
                    <h1 class="text-6xl font-bold text-gray-800 tracking-wide mb-4" style="font-family: serif;">
                        CERTIFICATE
                    </h1>
                    <p class="text-xl text-gray-600 tracking-widest uppercase mb-8">Of Completion</p>
                    <p class="text-sm text-gray-500 italic mb-8">proudly presented to</p>

                    <!-- Student Name -->
                    <h2 class="text-5xl font-bold mb-8" style="font-family: serif; background: linear-gradient(135deg, #9333ea, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        {{ $certificate->user->name }}
                    </h2>

                    <!-- Course Title -->
                    <p class="text-gray-600 text-sm mb-2">for successfully completing the online course</p>
                    <h3 class="text-2xl font-semibold text-gray-800 max-w-2xl mx-auto">
                        {{ $certificate->course->title }}
                    </h3>
                </div>

                <!-- Footer with Signatures -->
                <div class="w-full">
                    <div class="flex items-end justify-between max-w-3xl mx-auto">
                        <!-- Instructor Signature -->
                        <div class="text-center">
                            <div class="border-t-2 border-gray-400 pt-2 min-w-[200px]">
                                <p class="font-semibold text-gray-800">{{ $certificate->course->instructor->name }}</p>
                                <p class="text-sm text-gray-600">Course Instructor</p>
                            </div>
                        </div>

                        <!-- Seal/Badge -->
                        <div class="flex-shrink-0">
                            <div class="relative w-24 h-24">
                                <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center transform rotate-12 shadow-lg">
                                    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-10 h-10 text-purple-600 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Platform Director -->
                        <div class="text-center">
                            <div class="border-t-2 border-gray-400 pt-2 min-w-[200px]">
                                <p class="font-semibold text-gray-800">imole Africa</p>
                                <p class="text-sm text-gray-600">Platform Director</p>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate Details -->
                    <div class="mt-8 text-center text-xs text-gray-500">
                        <p>Certificate Number: <span class="font-mono font-semibold text-purple-700">{{ $certificate->certificate_number }}</span></p>
                        <p>Issued on: {{ $certificate->issued_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Decorative Corner Elements -->
            <div class="absolute top-12 left-12 w-16 h-16 border-t-4 border-l-4 border-purple-400 rounded-tl-3xl"></div>
            <div class="absolute top-12 right-12 w-16 h-16 border-t-4 border-r-4 border-purple-400 rounded-tr-3xl"></div>
            <div class="absolute bottom-12 left-12 w-16 h-16 border-b-4 border-l-4 border-pink-400 rounded-bl-3xl"></div>
            <div class="absolute bottom-12 right-12 w-16 h-16 border-b-4 border-r-4 border-pink-400 rounded-br-3xl"></div>
        </div>
    </div>
</body>
</html>
