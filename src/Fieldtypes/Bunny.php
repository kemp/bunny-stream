<?php

namespace Laborb\BunnyStream\Fieldtypes;
 
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Bunny extends \Statamic\Fieldtypes\Select
{
    protected $icon = 'video';
    protected $component = 'select';

    private static $memoizedOptions;

    protected function configFieldItems(): array
    {
        $parent = parent::configFieldItems();

        // Remove the "Options" element, as the options are pulled from Bunny
        array_shift($parent);

        return $parent;
    }

    protected function getOptions(): array
    {
        return static::$memoizedOptions ??= Http::withHeaders([
            'Accept' => 'application/json',
            'AccessKey' => config('statamic.bunny.apiKey'),
        ])
            ->throw()
            ->get(sprintf("https://video.bunnycdn.com/library/%s/videos?page=1&itemsPerPage=100&orderBy=date", config('statamic.bunny.libraryId')))
            ->collect('items')
            ->map(fn ($item) => [
                'value' => $item['guid'],
                'label' => sprintf('%s (%s)', $item['title'], Carbon::parse($item['dateUploaded'])->format('Y-m-d'))
            ])
            ->values()
            ->all();
    }
}
