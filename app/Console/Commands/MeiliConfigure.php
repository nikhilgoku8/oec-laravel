<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client;
use App\Models\Admin\Product;

class MeiliConfigure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:meili-configure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure Meilisearch index settings for Scout models';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $model = new Product;
        $indexName = $model->searchableAs();

        $settings = [
            'filterableAttributes' => ['filter_value_ids', 'sub_category_id'],
            'sortableAttributes'   => ['title'],
            'pagination' => [
                'maxTotalHits' => 10000,
            ],
        ];

        $client->index($indexName)->updateSettings($settings);
        $this->info("Configured index: $indexName");
    }
}
