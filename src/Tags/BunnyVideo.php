<?php

namespace Laborb\BunnyStream\Tags;

use Illuminate\Support\Facades\Http;

class BunnyVideo extends \Statamic\Tags\Tags
{
    protected static $handle = "bunny_video";

    public function index()
    {
        $libraryId = config("statamic.bunny.libraryId");

        $request = $this->getVideo($this->params->get("id"));

        if ($request->status() != 200) {
            return "Video not found";
        }

        $data = [
            "libraryId" => $libraryId,
            "id" => $this->params->get("id"),
        ];

        return view("bunny::video", $data);
    }

    private function getVideo($videoId)
    {
        return Http::withHeaders([
            "accept" => "application/json",
            "AccessKey" => config("statamic.bunny.apiKey"),
        ])->get(
            "https://video.bunnycdn.com/library/" .
                config("statamic.bunny.libraryId") .
                "/videos/" .
                $videoId
        );
    }
}
