<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feed;

class FeedsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $feedItems = Feed::orderBy('id', 'asc')->paginate(10);
        return view('feeds.index', ['feedItems' => $feedItems]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        // create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->save();
        return redirect('/posts')->with('success', 'Post created successfully !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Feed::find($id);
        return view('feeds.edit', ['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $feed = Feed::find($id);
        $feed->title = $request->input('title');
        $feed->description = $request->input('description');
        $feed->link = $request->input('link');
        $feed->save();
        return redirect('/feeds');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feed = Feed::find($id);
        $feed->delete();
        
    }

    public function handleFeed(Request $request) {
        $url = $request->input('url');
        $listOfargs =  explode( ',', $url );
        
        $feedItems = [];
        foreach($listOfargs as $url) {
            $xmlContents = simplexml_load_file($url);
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
        }
        return view('feeds.search')->with('feedItems', $feedItems);
    }
}
