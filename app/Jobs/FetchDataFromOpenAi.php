<?php

namespace App\Jobs;

use App\Models\Media;
use App\Models\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class FetchDataFromOpenAi implements ShouldQueue
{
    use Queueable;

    private string $prompt = 'You are designed to analyse and return a JSON payload with: - person_count - the number of people found in the image, weather - 1/2 word summary of the weather conditions, activity_type - motorcycle or car, brands - array of recognised brands, tags - array of stand out details, description - max 200 chars, sport - the sport name';

    public function __construct(public int $mediaId)
    {
        //
    }

    public function handle(): void
    {
        /** @var Media $media */
        $media = Media::findOrFail($this->mediaId);

        $response = Http::withToken(config('services.openai.api_key'))
            ->asJson()
            ->withHeader('OpenAI-Beta', 'assistants=v2')
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4-turbo',
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => $this->prompt,
                            ],
                        ]
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => $media->url,
                                    'detail' => 'low',
                                ],

                            ]
                        ]
                    ]
                ]
            ]);

        if ($response->successful()) {
            $json = json_decode($response->json('choices.0.message.content'));

            Model::withoutEvents(function () use ($media, $json) {
                $media->forceFill([
                    'ai_analysed' => true,
                    'description' => $json->description
                ])->save();

                $media->tags()->sync(
                    collect([...$json->brands, ...$json->tags, $json->sport])
                        ->filter()
                        ->map(fn (string $tag) => Tag::firstOrCreate(['name' => strtolower($tag)]))
                        ->pluck('id')
                );
            });

            $media->searchable();
        }
    }

}
