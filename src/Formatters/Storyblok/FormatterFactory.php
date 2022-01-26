<?php

namespace Digitlimit\StoryblokAlgolia\Formatters\Storyblok;

use Illuminate\Support\Str;
use Exception;

class FormatterFactory
{
    /**
     * Create a new formatter instance.
     */
    public function make(string $type, array $story): FormatterInterface
    {
        $class_name = Str::studly($type);
        $class = "App\\Formatters\\Storyblok\\{$class_name}Formatter";

        if (!$class_name || !class_exists($class)) {
            throw new Exception("Formatter class {$class} does not exist");
        }

        return new $class($story);
    }
}
