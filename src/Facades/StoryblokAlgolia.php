<?php

namespace Digitlimit\StoryblokAlgolia\Facades;

use Illuminate\Support\Facades\Facade;

class StoryblokAlgolia extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'storyblok-algolia';
    }
}
