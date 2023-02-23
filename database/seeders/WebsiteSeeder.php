<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Website;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $websites = [
            ['name' => 'TechCrunch', 'url' => 'https://techcrunch.com', 'rss_feed_url' => 'https://techcrunch.com/feed/'],
            ['name' => 'Wired', 'url' => 'https://www.wired.com', 'rss_feed_url' => 'https://www.wired.com/feed/rss'],
            ['name' => 'Mashable', 'url' => 'https://mashable.com', 'rss_feed_url' => 'https://mashable.com/feeds/rss/'],
        ];

        foreach ($websites as $website) {
            Website::create($website);
        }
    }
}
