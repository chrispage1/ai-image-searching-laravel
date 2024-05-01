<div>

    <div class="flex items-center">
        <div class="mx-auto w-1/3 p-6">
            <input
                wire:model.live.debounce.10ms="query"
                type="search"
                placeholder="Enter search query"
                class="w-full p-2 border border-gray-300 rounded-lg"
            />
        </div>
    </div>

    <div class="m-12">
        @if($media->isEmpty())
            <div class="text-lg text-center">
                No media found
            </div>
        @endif

        <div class="grid grid-cols-4 gap-2">
            @foreach($media as $item)
                <img src="{{ $item->url }}" alt="{{ $item->file_name }}" class="w-full h-full aspect-video object-cover" />
            @endforeach
        </div>
    </div>
</div>
