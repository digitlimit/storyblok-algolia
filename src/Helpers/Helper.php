<?php

namespace Digitlimit\StoryblokAlgolia\Helpers;

/**
 * Helper class for misc. functions.
 */
class Helper 
{

    /**
     * Convert array to object
     *
     * @param array $items
     * @return object
     */
    public static function arrayToObject(array $items) : object
    {
        return json_decode(
            json_encode($items, JSON_FORCE_OBJECT)
        );
    }
}