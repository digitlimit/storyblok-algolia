<?php

namespace Digitlimit\StoryblokAlgolia\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Digitlimit\StoryblokAlgolia\Services\StoryblokService;

class StoryblokController extends Controller
{
    protected $storyblokService;

    /**
     * Create a new controller instance.
     * @param StoryblokService $storyblokService
     *
     * @return void
     */
    public function __construct(StoryblokService $storyblokService)
    {
        $this->storyblokService = $storyblokService;
    }

    /**
     * Get the Storyblok data.
     *
     * @return \Illuminate\Http\Response
     */
    public function runIndex()
    {
        $this->storyblokService
            ->handleStories();

        return response()
            ->json(['success' => true]);
    }

    /**
     * Handle Storyblok webhooks.
     *
     * @return Client
     */
    public function webhook(Request $request)
    {
        return $this
            ->storyblokService
            ->handleWebhook(
                $request
            );
    }
}
