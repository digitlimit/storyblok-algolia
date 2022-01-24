<?php

namespace Digitlimit\StoryblokAlgolia\Helpers;

use Algolia\AlgoliaSearch\SearchClient;

class AlgoliaHelper
{
    protected $client;

    /**
     * Get the Algolia client.
     *
     * @return SearchClient
     */
    public function __construct()
    {
        $this->client = SearchClient::create(
            config('algolia.id'),
            config('algolia.secret'),
        );
    }
  
    /**
     * Add an object to algolia index.
     * 
     * @param  string $index
     * @param  array  $object
     *
     * @return self
     */
    public function add(string $index, array $object) : self
    {
        $this->client
            ->initIndex($index)
            ->saveObject($object);

        return $this;
    }

    /**
     * Add many object to algolia index.
     * 
     * @param  string $index
     * @param  array  $object
     *
     * @return self
     */
    public function addMany(string $index, array $objects) : self
    {
        $this->client
            ->initIndex($index)
            ->saveObjects($objects);

        return $this;
    }

    /**
     * Remove an object from the Algolia index.
     * 
     * @param  string $index
     * @param  string  $object_id
     * 
     * @return self
     */
    public function delete(string $index, string $object_id) : self 
    {
        $this->client
            ->initIndex($index)
            ->deleteObjects([$object_id]);

        return $this;
    }

    /**
     * Search algolia index.
     *
     * @return array
     */
    public function search(string $index, string $query, $cache = true)
    {
        $cache_key = "algolia_index_products_{$query}";
        $cache_expire = $cache ? config('algolia.cache_expire') : 0;

        //lets use cache to minimize API calls
        return cache()->remember(
            $cache_key,
            $cache_expire,
            function () use ($query, $index) {
                return $this->client
                    ->initIndex($index)
                    ->search($query);
            }
        );
    }
}
