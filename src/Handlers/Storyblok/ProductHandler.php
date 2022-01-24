<?php

namespace Digitlimit\StoryblokAlgolia\Handlers\Storyblok;

use Digitlimit\StoryblokAlgolia\Helpers\StoryblokHelper;
use Digitlimit\StoryblokAlgolia\Events\StoryblokPublished;
use Digitlimit\StoryblokAlgolia\Events\StoryblokUnpublished;
use Digitlimit\StoryblokAlgolia\Events\StoryblokDeleted;


use Digitlimit\StoryblokAlgolia\Helpers\Helper;
use Digitlimit\StoryblokAlgolia\Formatters\Storyblok\Formatter;
use Digitlimit\StoryblokAlgolia\Formatters\Storyblok\ProductFormatter;

class ProductHandler implements HandlerInterface
{
    
    /**
     * Return array of types handled.
     *
     * @return array
     */
    public function type(): array
    {
        return ['product'];
    }

    /**
     * Handle Storyblok publish event.
     *
     * @param object $payload
     * @param Digitlimit\StoryblokAlgolia\Helpers\StoryblokHelper $storyblok
     * @return void
     */
    public function published(object $payload, StoryblokHelper $storyblok) : void
    {
        $story = $storyblok
            ->getStory($payload->story_id);

        $page_type = $story['content']['component'];

        if ($page_type == 'product') {
            $formatted_story = $this->formatter->setFormat(
                new ProductFormatter($story)
            )->getFormat();

            $this->algoliaHelper
                ->add('products', $formatted_story);

            info(['published' => $formatted_story]);
        } else {
            info("Page type '{$page_type}' not supported");
        }
    }

    /**
     * Handle Storyblok unpublish event.
     *
     * @param object $payload
     * @param Digitlimit\StoryblokAlgolia\Helpers\StoryblokHelper $storyblok
     * @return void
     */
    public function unpublished(object $payload, StoryblokHelper $storyblok) : void
    {
        $story = $storyblok->getStory($payload->slug);
        $product = $storyblok->formatter->format($story);
        $algolia = $storyblok->algoliaHelper->format($product);
        $storyblok->algoliaHelper->delete($algolia);
        event(new StoryblokUnpublished($product));
    }

    /**
     * Handle Storyblok delete event.
     *
     * @param object $payload
     * @param Digitlimit\StoryblokAlgolia\Helpers\StoryblokHelper $storyblok
     * @return void
     */
    public function delete(object $payload, StoryblokHelper $storyblok) : void
    {
        $story = $storyblok->getStory($payload->slug);
        $product = $storyblok->formatter->format($story);
        $algolia = $storyblok->algoliaHelper->format($product);
        $storyblok->algoliaHelper->delete($algolia);
        event(new StoryblokDeleted($product));
    }
}
