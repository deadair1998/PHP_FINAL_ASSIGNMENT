<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use App\Feed;

class ReadFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read:feed {url=test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        try {
            $url = $this->argument('url');//https://tuoitre.vn/rss/the-gioi.rss           
            $headers = ['ID','Title', 'Category','Publish Date'];

            if($url == 'test') {
                $events = Feed::all(['id', 'title', 'category', 'pubDate'])->where('category', 'test')->toArray();
                return $this->table($headers, $events);
            };
            
            //use exploid method to split url into array
            $listOfargs = explode(',', $url);
            $progressBar = $this->output->createProgressBar(count($listOfargs));
            
            $readFileXML = function($curVal) {
                $xmlContents = simplexml_load_file($curVal);
                $feedItems = [];
                
                foreach($xmlContents->channel->item as $item) {
                    $feed = new Feed;
                    $feed->title = $item->title;
                    $feed->description = $item->description;
                    $feed->category = 'category';
                    $feed->pubDate = $item->pubDate;
                    $feed->link = $item->link;
                    $feed->save();
                    array_push($feedItems, $item);
                }              
                return $feedItems;
            };

            $progressBar->start();           
            $items = array_map($readFileXML, $listOfargs);
            $progressBar->finish();
            
            if ($this->confirm('Do you want to see all items in here ?')) {
                return $this->info(var_dump($items));
            }
            
        } catch (\Exception $e) {
            //DB::rollBack();           
            $this->error($e->getMessage());
        }        
    }
}
