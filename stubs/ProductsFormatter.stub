<?php

namespace Digitlimit\StoryblokAlgolia\Formatters\Storyblok;
use Carbon\Carbon;
use Digitlimit\StoryblokAlgolia\Helpers\Helper;

class ProductsFormatter implements FormatterInterface
{
    protected $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Format the Storyblok product data.
     *
     * @param array $products
     * @return array $products with formatted data
     */
    public function format() : array
    {
        return collect($this->products)->map(
            function ($item) {

                $product = Helper::arrayToObject($item);
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
        )->toArray();
    }
}
