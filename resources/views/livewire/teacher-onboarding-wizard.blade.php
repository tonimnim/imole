<div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button type="submit">
                Complete Onboarding
            </x-filament::button>
        </div>
    </form>
</div>
