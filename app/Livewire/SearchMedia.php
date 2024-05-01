<?php

namespace App\Livewire;

use App\Models\Media;
use Livewire\Component;

class SearchMedia extends Component
{
    public string $query = '';

    public function render()
    {
        $media = Media::search($this->query)
            ->query(fn ($builder) => $builder->where('ai_analysed', true))
            ->get();

        return view('livewire.search-media', compact('media'));
    }
}
