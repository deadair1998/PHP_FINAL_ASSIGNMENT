@extends('layouts/app')
  @section('content')
    <div class="s130">
      <form action="{{ url('handle-feed') }}" method="POST" role="form">
        {{ csrf_field()}}
        <div class="inner-form">
          <div class="input-field first-wrap">
            <div class="svg-wrapper">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
              </svg>
            </div>
            <input id="search" type="text" placeholder="What are you looking for?" name="url"/>
          </div>
          <div class="input-field second-wrap">
            <button class="btn-search" type="submit">SEARCH</button>
          </div>
        </div>
        <span class="info">ex : https://www.feedforall.com/sample.xml</span>
      </form>
    </div>

    @if (isset($feedItems))
      <div class="container">
        @foreach ($feedItems as $item)
            <div class="card border-success" id="card_{{$item->id}}">
                <div class="card-body">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-id="{{$item->id}}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    
                    <h5 class="card-title">{{$item->title}}</h5>                  
                    <p class="card-text">{!! $item->description !!}</p>
                    <small>Date : {{$item->pubDate}}</small><br>
                    <a href="{{$item->link}}" class="btn btn-primary" target="_blank">Detail</a>
                    <a href="feeds/{{$item->id}}/edit" class="btn btn-warning" >Update</a>
                </div>
            </div><br id="br_{{$item->id}}">
        @endforeach
          {!! $feedItems->links() !!}
      </div>
      
    @endif
    
    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h4> Are you sure delete this data ?</h4>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-danger" id="delButton">Delete</button>
              <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    
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