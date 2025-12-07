<x-filament-panels::page>
    @push('styles')
        @vite('resources/css/app.css')
    @endpush

    @vite('resources/js/student-home.js')

    <div id="student-home" data-user-name="{{ auth()->user()->name }}"></div>
</x-filament-panels::page>
