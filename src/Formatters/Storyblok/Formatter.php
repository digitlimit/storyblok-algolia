<?php

namespace Digitlimit\StoryblokAlgolia\Formatters\Storyblok;

/**
 * Formatter class
 * @package App\Formatters\Storyblok
 */
class Formatter
{
    protected $formatter;

    public function setFormat(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }

    public function getFormat() : array
    {
        return $this
            ->formatter
            ->format();
    }
}
