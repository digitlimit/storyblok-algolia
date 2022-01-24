<?php 

namespace Digitlimit\StoryblokAlgolia\Services;

use Illuminate\Http\Request;
use Digitlimit\StoryblokAlgolia\Helpers\StoryblokHelper;
use Digitlimit\StoryblokAlgolia\Helpers\AlgoliaHelper;
use Digitlimit\StoryblokAlgolia\Formatters\Storyblok\Formatter;
use Digitlimit\StoryblokAlgolia\Formatters\Storyblok\ProductFormatter;
use Digitlimit\StoryblokAlgolia\Formatters\Storyblok\ProductsFormatter;

class StoryblokService 
{
    protected $storyblokHelper;
    protected $algoliaHelper;
    protected $formatter;

    /**
     * Create a new controller instance.
     * @param StoryblokHelper $storyblokHelper
     * @param AlgoliaHelper $algoliaHelper
     * @param Formatter $formatter
     *
     * @return void
     */
    public function __construct(
        StoryblokHelper $storyblokHelper,
        AlgoliaHelper $algoliaHelper,
        Formatter $formatter
    ) {
        $this->storyblokHelper = $storyblokHelper;
        $this->algoliaHelper = $algoliaHelper;
        $this->formatter = $formatter;
    }

    /**
     * Handle Storyblok webhooks.
     *
     * @return Client
     */
    public function handleWebhook(Request $request)
    {
        info('Storyblok webhook received');

        $this->storyblokHelper->handleWebhook(
            $request,
            fn($payload, $storyblok) => $this->handlePublished(
                $payload, $storyblok
            ),
            fn($payload, $storyblok) => $this->handleUnpublished(
                $payload, $storyblok
            ),
            fn($payload, $storyblok) => $this->handleUnpublished(
                $payload, $storyblok
            ),
        );

        return response()
            ->json(['success' => true]);
    }

    /**
     * Handle published Storyblok stories.
     *
     * @return Client
     */
    public function handleStories()
    {
        $stories = $this->storyblokHelper
            ->getStories(
                'product',
                [
                    'is_startpage' => 0,
                    'per_page' => 100,
                ]
            );

            $formatted_stories = $this->formatter->setFormat(
                new ProductsFormatter($stories)
            )->getFormat();

            $this->algoliaHelper
                ->addMany('products', $formatted_stories);
    }

    /**
     * Handle published Storyblok stories.
     *
     * @return Client
     */ 
    protected function handlePublished(object $payload, StoryblokHelper $storyblok)
    {
        $story = $storyblok
            ->getStory($payload->story_id);

        $page_type = $story['content']['component'];

        $formatterClass = 'App\Formatters\Storyblok\\' 
            . ucfirst($page_type) 
            . 'Formatter';

        if (class_exists($formatterClass)) {
            $formatted_story = $this->formatter->setFormat(
                new $formatterClass($story)
            )->getFormat();

            $this->algoliaHelper
                ->add(strtolower($page_type), $formatted_story);

            info(['published' => $formatted_story]);
        } else {
            info("Page type '{$page_type}' formatter not found");
        }

        // if ($page_type == 'product') {
        //     $formatted_story = $this->formatter->setFormat(
        //         new ProductFormatter($story)
        //     )->getFormat();

        //     $this->algoliaHelper
        //         ->add('products', $formatted_story);

        //     info(['published' => $formatted_story]);
        // } else {
        //     info("Page type '{$page_type}' not supported");
        // }
    }

    /**
     * Handle published Storyblok stories.
     *
     * @return Client
     */
    protected function handleUnpublished(object $payload, StoryblokHelper $storyblok)
    {
        $story = $storyblok
            ->getStory($payload->story_id);

        $object_id = $story['uuid'];

        $page_type = $story['content']['component'];

        $algolia_index = strtolower($page_type);

        // @todo check algolia index exists
        // if not create index

        $this->algoliaHelper
            ->delete($algolia_index, $object_id);

        // if ($page_type == 'product') {
           

        //     info(['unpublished' => $object_id]);
        // } else {
        //     info("Page type '{$page_type}' not supported");
        // }
    }
}