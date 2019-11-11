<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem; 

class Event extends Model implements Feedable
{
    public function toFeedItem() {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->description)
            ->updated($this->updated_at)
            ->link($this->link)
            ->author($this->author);
    }

    public static function getFeedItems() {
        return static::all();
    }

    public function getLinkAttribute() {
        return route('events.show', $this);
    }
}
