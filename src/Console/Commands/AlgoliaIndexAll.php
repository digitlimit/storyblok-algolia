<?php

namespace Digitlimit\StoryblokAlgolia\Console\Commands;

use Illuminate\Console\Command;

class AlgoliaIndexAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'algolia-index:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all Storyblok objects in Algolia';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
