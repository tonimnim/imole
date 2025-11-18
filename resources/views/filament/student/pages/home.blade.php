<x-filament-panels::page>
    <div class="space-y-6">
        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
            <x-filament::card style="flex: 1; min-width: 250px;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Enrolled Courses</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">0</p>
                    </div>
                    <div class="rounded-full bg-primary-100 p-3 dark:bg-primary-900">
                        <x-filament::icon
                            icon="heroicon-o-book-open"
                            class="h-8 w-8 text-primary-600 dark:text-primary-400"
                        />
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card style="flex: 1; min-width: 250px;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Certificates Earned</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">0</p>
                    </div>
                    <div class="rounded-full bg-success-100 p-3 dark:bg-success-900">
                        <x-filament::icon
                            icon="heroicon-o-trophy"
                            class="h-8 w-8 text-success-600 dark:text-success-400"
                        />
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card style="flex: 1; min-width: 250px;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Hours Learned</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">0</p>
                    </div>
                    <div class="rounded-full bg-warning-100 p-3 dark:bg-warning-900">
                        <x-filament::icon
                            icon="heroicon-o-clock"
                            class="h-8 w-8 text-warning-600 dark:text-warning-400"
                        />
                    </div>
                </div>
            </x-filament::card>
        </div>
    </div>
</x-filament-panels::page>
