<?php

namespace Digitlimit\StoryblokAlgolia\Services;

use Illuminate\Http\Request;
use Digitlimit\StoryblokAlgolia\Helpers\StoryblokHelper;
use Digitlimit\StoryblokAlgolia\Helpers\AlgoliaHelper;
use Digitlimit\StoryblokAlgolia\Formatters\Storyblok\Formatter;
use Digitlimit\StoryblokAlgolia\Formatters\Storyblok\FormatterFactory;
use Digitlimit\StoryblokAlgolia\Helpers\Logger;
use Exception;

class StoryblokService
{
    protected $storyblokHelper;
    protected $algoliaHelper;
    protected $formatter;
    protected $formatterFactory;

    /**
     * Create a new controller instance.
     * @param StoryblokHelper $storyblokHelper
     * @param AlgoliaHelper $algoliaHelper
     * @param FormatterFactory $formatterFactory
     * @param Formatter $formatter
     *
     * @return void
     */
    public function __construct(
        StoryblokHelper $storyblokHelper,
        AlgoliaHelper $algoliaHelper,
        Formatter $formatter,
        FormatterFactory $formatterFactory
    ) {
        $this->storyblokHelper = $storyblokHelper;
        $this->algoliaHelper = $algoliaHelper;
        $this->formatter = $formatter;
        $this->formatterFactory = $formatterFactory;
    }

    /**
     * Handle Storyblok webhooks.
     *
     * @return Client
     */
    public function handleWebhook(Request $request)
    {
        Logger::info('Storyblok webhook received');

        try {
            $this->storyblokHelper->handleWebhook(
                $request,
                function ($payload, $storyblok) {
                    $this->handlePublished($payload, $storyblok);
                },
                function ($payload, $storyblok) {
                    $this->handleUnpublished($payload, $storyblok);
                },
                function ($payload, $storyblok) {
                    $this->handleUnpublished($payload, $storyblok);
                },
            );
        } catch (Exception $e) {
            Logger::info('Storyblok webhook failed: ' . $e->getMessage());
            return;
        }

        return response()
            ->json(['success' => true]);
    }

    /**
     * Handle published Storyblok stories.
     *
     * @return Client
     */
    public function handleStories(
        string $page_type,
        string $algolia_index,
        array $storyblok_options = []
    ) {
        $options = array_merge(
            ['is_startpage' => 0,'per_page' => 100,], 
            $storyblok_options
        );

        $stories = $this->storyblokHelper
            ->getStories(
                $page_type,
                $options
            );

        $formatterClass = $this->formatterFactory
            ->make($page_type, $stories);

        $formatted_stories = $this->formatter->setFormat(
            $formatterClass
        )->getFormat();

        $this->algoliaHelper
            ->addMany($algolia_index, $formatted_stories);
    }

    /**
     * Handle published Storyblok stories.
     *
     * @return Client
     */
    protected function handlePublished(object $payload, StoryblokHelper $storyblok)
    {
        Logger::info('Handle published Storyblok story -- start');

        $story = $storyblok
            ->getStory($payload->story_id);

        Logger::info(['story' => $story]);

        $page_type = $story['content']['component'];

        Logger::info(['page_type' => $page_type]);

        $formatterClass = $this->formatterFactory
            ->make($page_type, $story);

        Logger::info(['formatterClass' => $formatterClass]);

        $formatted_story = $this->formatter->setFormat(
            new $formatterClass($story)
        )->getFormat();

        Logger::info(['formatted_story' => $formatted_story]);

        $this->algoliaHelper
            ->add(strtolower($page_type), $formatted_story);

        Logger::info("Story published: {$story['content']['title']}");

        Logger::info('Handle published Storyblok story -- done');
    }

    /**
     * Handle published Storyblok stories.
     *
     * @return Client
     */
    protected function handleUnpublished(object $payload, StoryblokHelper $storyblok)
    {
        Logger::info('Handle unpublished Storyblok story -- start');

        $story = $storyblok
            ->getStory($payload->story_id);

        Logger::info(['story' => $story]);

        $object_id = $story['uuid'];

        Logger::info(['object_id' => $object_id]);

        $page_type = $story['content']['component'];

        Logger::info(['page_type' => $page_type]);

        $algolia_index = strtolower($page_type);

        // @todo check algolia index exists
        // if not create index
        Logger::info(['algolia_index' => $algolia_index]);

        $this->algoliaHelper
            ->delete($algolia_index, $object_id);

        Logger::info('Handle unpublished Storyblok story -- done');     
    }
}
