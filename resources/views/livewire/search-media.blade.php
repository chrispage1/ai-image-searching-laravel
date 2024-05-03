<div wire:poll>

    <div class="flex items-center">
        <div class="mx-auto w-1/3 p-6">
            <input
                wire:model.live.debounce="query"
                type="search"
                placeholder="Enter search query"
                class="w-full p-2 border border-gray-300 rounded-lg"
            />
        </div>
    </div>

    <div class="m-6">
        @if($media->isEmpty())
            <div class="text-lg text-center">
                No media found
            </div>
        @endif

        <div class="text-center text-lg font-bold mb-8">
            Showing {{ $count = $media->count() }} {{ Str::plural('result', $count) }}
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($media as $item)
                <div>
                    <div class="mb-4">
                        <img src="{{ $item->url }}" alt="{{ $item->file_name }}" class="w-full h-full aspect-video object-cover" />
                    </div>
                    <div class="col-span-3">
                        <span class="block mb-3 text-lg"><strong>Description</strong>: {{ $item->description }}</span>
                        <strong>Tags</strong>: {{ $item->tags->pluck('name')->implode(', ') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
