@extends('layouts.app')

@section('content')
    <div class="card-header">			  
            <div class="d-flex justify-content-end">
                <div class="mr-auto p-2"><h3>Send Email sharing your wishlist</h3></div>
                <div class="p-2">				
                    @if (!Auth::guest())
                        {!! Form::open(['route' => 'wishlist.index', 'method' => 'GET', 'class' => 'navbar-form text-right']) !!}
                            <div class="form-group">	
                                {!! Form::submit('Back to my wishlist ', ['class' => 'btn btn-info']) !!}
                            </div>
                        {!! Form::close()  !!}
                    @endif		
                </div>				
            </div>
        </div>

    <div class="card-body">

    <div class="container box">
         <form method="post" action="{{ url('sendemail/send') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label> To </label>
                <input type="text" name="friend_name" class="form-control" />                    
            </div>
            <br />
            <div class="form-group">
                    <label> Email </label>
                    <input type="text" name="friend_email" class="form-control" />                    
            </div>
            <br />
            <div class="form-group">
                <label> Enter your message </label>

                
                {!! Form::textarea('message', '', ['id' => 'article-ckeditor', 'class' => 'form-control textarea-content','placeholder' => 'Your message']) !!}
            </div>
            <br />
            <div class="form-group">
                    <input type="submit" name="send" value="Send" class="btn btn-success" />                    
            </div>
        </form> 
    </div>
@endsection