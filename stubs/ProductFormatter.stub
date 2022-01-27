<?php

namespace Digitlimit\StoryblokAlgolia\Formatters\Storyblok;
use Carbon\Carbon;
use Digitlimit\StoryblokAlgolia\Helpers\Helper;

class ProductFormatter implements FormatterInterface
{
    protected $product;

    public function __construct(array $product)
    {
        $this->product = $product;
    }

    /**
     * Format the Storyblok product data.
     *
     * @param array $product
     * @return array $product with formatted data
     */
    public function format() : array
    {
        $product = Helper::arrayToObject($this->product);
        $date = new Carbon($product->first_published_at);

        return [
            'objectID'  => $product->uuid,
            'name'      => $product->name,
            'slug'      => $product->slug,
            'full_slug' => $product->full_slug,
            'date'      => $date,
            '_uid'      => optional($product->content)->_uid,
            'title'     => optional($product->content)->title,
            'intro'     => optional($product->content)->intro,
        ];
    }
}
