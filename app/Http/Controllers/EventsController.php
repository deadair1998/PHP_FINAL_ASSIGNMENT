<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventsController extends Controller
{
    public function show(Request $request, Event $event) {
        return $event;
    }
}
