<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h3>
                    <p class="mb-4">Manage your courses and students from here.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg">My Courses</h4>
                            <p class="text-sm text-gray-600">Create and manage your courses</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg">Students</h4>
                            <p class="text-sm text-gray-600">View and grade your students</p>
                        </div>
                        <div class="bg-orange-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-lg">Assignments</h4>
                            <p class="text-sm text-gray-600">Create and review assignments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
