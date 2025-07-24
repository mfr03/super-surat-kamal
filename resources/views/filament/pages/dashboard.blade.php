<x-filament-panels::page>
    
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
        @foreach ($this->getVisibleWidgets() as $widget)
            @livewire($widget)
        @endforeach
    </div>
</x-filament-panels::page>
