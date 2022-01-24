<?php

namespace Digitlimit\StoryblokAlgolia\Helpers;

use Closure;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Illuminate\Http\Request;
use Storyblok\Client;
use Digitlimit\StoryblokAlgolia\Events\StoryblokPublished;
use Digitlimit\StoryblokAlgolia\Events\StoryblokUnpublished;
use Digitlimit\StoryblokAlgolia\Events\StoryblokDeleted;

class StoryblokHelper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(config('storyblok.oauth_token'));
    }

    /**
     * Get the Storyblok strories.
     *
     * @return Client
     */
    public function getStories(string $slug, array $options = []) : array
    {
        // Optionally set a cache
        if (config('storyblok.cache')) {
            $this->client->setCache(
                'filesytem',
                array('path' => config('storyblok.cache_path'))
            );
        }

        $new_options = array_merge(
            [
                'is_startpage' => 0,
                'per_page' => config('storyblok.per_page'),
            ],
            $options
        );
        
        // Get all Stories that start with news
        return $this->client
            ->getStories($new_options)
            ->getBody()['stories'];
    }

    /**
     * Get the Storyblok story.
     *
     * @return array $story
     */
    public function getStory(string $slug) : array
    {

        $story = $this->client
            ->editMode()
            ->getStoryBySlug($slug)
            ->getBody()['story'];
            
        return $story;
    }

    /**
     * Handle storyblok webhooks.
     *
     * @return Client
     */
    public function handleWebhook(
        Request $request,
        Closure $published = null,
        Closure $unpublished = null,
        Closure $deleted = null
    ) {
        if ($request->headers->get('webhook-signature') === null) {
            throw new BadRequestHttpException('Header not set');
        }

        $signature = hash_hmac(
            'sha1',
            $request->getContent(),
            config('storyblok.webhook_secret')
        );

        $action = $request->action;

        if ($request->header('webhook-signature') === $signature) {

            $payload = json_decode($request->getContent());

            switch ($action) {
            case 'published':
                event(new StoryblokPublished($payload, $this));
                if (is_callable($published)) {
                    $published($payload, $this);
                }
                break;
            case 'unpublished':
                event(new StoryblokUnpublished($payload, $this));
                if (is_callable($unpublished)) {
                    $unpublished($payload, $this);
                }
                break;
            case 'deleted':
                event(new StoryblokDeleted($payload, $this));
                if (is_callable($deleted)) {
                    $deleted($payload, $this);
                }
                break;
            }

            return true;
        }

        throw new BadRequestHttpException('Signature has invalid format');
    }
}
