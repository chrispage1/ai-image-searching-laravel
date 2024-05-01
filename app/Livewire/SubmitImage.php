<?php

namespace App\Livewire;

use App\Jobs\FetchDataFromOpenAi;
use App\Models\Media;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SubmitImage extends Component
{
    #[Validate('url'), Validate('required'), Validate('unique:media,url'), Validate('ends_with:.jpg,.webp')]
    public string $url = '';

    #[Locked]
    public string $message = '';

    public function render()
    {
        return view('livewire.submit-image');
    }

    public function submit(): void
    {
        $this->message = '';
        $this->validate();

        $filename = substr($this->url, strrpos($this->url, '/') + 1);

        $media = Media::create(['file_name' => $filename, 'url' => $this->url]);
        dispatch(new FetchDataFromOpenAi($media->id));

        $this->message = 'Media has been submitted for analysis';
        $this->reset('url');
    }
}
