<?php

namespace Digitlimit\StoryblokAlgolia\Formatters\Storyblok;

/**
 * Formatter Interface
 * @package App\Formatters\Storyblok
 */
interface FormatterInterface
{

    /**
     * Format the Storyblok data.
     *
     * @param array $items
     * @return array $items with formatted data
     */
    public function format() : array;
}
