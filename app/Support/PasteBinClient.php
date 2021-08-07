<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PasteBinClient
{
    /** @var string */
    private string $url;

    /**
     * PasteBinClient constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->url = Str::finish($config['url'], '/');
    }

    /**
     * Get the content for the given resource.
     *
     * @param string $url
     *
     * @return string
     */
    public function get(string $url): string
    {
        return Http::get($this->makeUrl($url))->body();
    }

    /**
     * Get a json response for the given resource.
     *
     * @param string $url
     *
     * @return array|mixed
     */
    public function json(string $url)
    {
        return Http::get($this->makeUrl($url))->json();
    }

    /**
     * Parse a resource into a full pastebin url.
     *
     * @param string $url
     *
     * @return string
     */
    public function makeUrl(string $url): string
    {
        return $this->url . ltrim($url, '/');
    }
}
