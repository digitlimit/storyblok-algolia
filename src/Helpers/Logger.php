<?php

namespace Digitlimit\StoryblokAlgolia\Helpers;

use Illuminate\Support\Facades\Log;

class Logger
{
    public static function info($message)
    {
        if (config('storyblok-algolia.debug')) {
            Log::info($message);
        }
    }

    // public static function error($message)
    // {
    //     if (config('storyblok-algolia.logging.error')) {
    //         \Log::error($message);
    //     }
    // }
}