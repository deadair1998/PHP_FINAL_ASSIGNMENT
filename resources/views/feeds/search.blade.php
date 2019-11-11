@extends('layouts/app')
  @section('content')
    

    @if (isset($feedItems))
      <div class="container">
        @foreach ($feedItems as $item)
            <div class="card border-success" id="card_{{$item->id}}">
                <div class="card-body">
                    <h5 class="card-title">{{$item->title}}</h5>                  
                    <p class="card-text">{!! $item->description !!}</p>
                    <small>Date : {{$item->pubDate}}</small><br>
                    <a href="{{$item->link}}" class="btn btn-primary" target="_blank">Detail</a>
                    
                </div>
            </div><br id="br_{{$item->id}}">
        @endforeach
      </div>
    @endif
    
    <!-- Modal -->
    

    
    <script>
      var feed_id;
      $(document).on('click', '.close', function() {
        feed_id = $(this).data("id");
        $('#confirmModal').modal('show');
      });

      $('#delButton').click(function(){
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax(
        {
            url: "feeds/"+feed_id,
            type: 'DELETE',
            data: {
                "id": feed_id,
                "_token": token,
            },
            success: function (){
                console.log("it Works");
                $('#confirmModal').modal('hide');
                $('#card_'+feed_id).fadeOut(500);
                $('#br_'+feed_id).remove();
            }
        });
      })
      
    </script>
  @endsection