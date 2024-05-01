<div>

    <form class="flex flex-col m-6 w-1/2" wire:submit="submit">
        <h4 class="text-lg font-semibold mb-2">Submit URL for analysis</h4>

        @if($this->message)
        <div class="bg-green-100 text-sm p-3 rounded-lg leading-none py-3 mb-2">
            {{ $this->message }}
        </div>
        @endif

        <input wire:model="url" type="url" placeholder="Enter image URL" class="w-full p-2 border border-gray-300 rounded-lg">

        @error('url')
            <span class="inline-block text-sm text-red-600 -mt-px">{{ $message }}</span>
        @enderror

        <button type="submit" class="bg-gray-900 text-white p-3 rounded mt-3 leading-none">
            Submit
        </button>
    </form>
</div>
