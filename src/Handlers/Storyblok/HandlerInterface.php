<?php

namespace Digitlimit\StoryblokAlgolia\Handlers\Storyblok;

use Digitlimit\StoryblokAlgolia\Helpers\StoryblokHelper;

/**
 * Handler Interface
 * @package App\Handlers\Storyblok
 */
interface HandlerInterface
{
    /**
     * Return array of types handled.
     *
     * @return array
     */
    public function type(): array;

    /**
     * Handle Storyblok publish event.
     *
     * @param object $payload
     * @param App\Helpers\StoryblokHelper $storyblok
     * @return void
     */
    public function published(object $payload, StoryblokHelper $storyblok) : void;

    /**
     * Handle Storyblok unpublish event.
     *
     * @param object $payload
     * @param App\Helpers\StoryblokHelper $storyblok
     * @return void
     */
    public function unpublished(object $payload, StoryblokHelper $storyblok) : void;

    /**
     * Handle Storyblok delete event.
     *
     * @param object $payload
     * @param App\Helpers\StoryblokHelper $storyblok
     * @return void
     */
    public function delete(object $payload, StoryblokHelper $storyblok) : void;
}
