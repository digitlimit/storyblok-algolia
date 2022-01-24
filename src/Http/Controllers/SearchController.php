<?php

namespace Digitlimit\StoryblokAlgolia\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Digitlimit\StoryblokAlgolia\Helpers\AlgoliaHelper;
use Algolia\AlgoliaSearch\SearchClient;

class SearchController extends Controller
{
    protected $algoliaHelper;

    public function __construct(AlgoliaHelper $algoliaHelper)
    {
        $this->algoliaHelper = $algoliaHelper;
    }

    /**
     * Display the landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Search the angolia resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->q;

        $objects = $this->algoliaHelper->search(
            'products',
            $query,
            $cache = true
        );

        return response($objects);
    }
}
