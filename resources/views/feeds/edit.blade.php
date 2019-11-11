@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Edit item</h1>
    <form action="{{ route('feeds.update', $item->id) }}" method="post">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$item->title}}">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Description</label>
            <textarea name='description' class="form-control" id="exampleInputPassword1" rows="5">{{$item->description}}</textarea>
        </div>
        <div class="form-group">
                <label for="exampleInputEmail1">Link</label>
                <input type="text" name='link' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$item->link}}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection