@extends('layouts.app')

@section('content')
    <div class="card-header">			  
        <div class="d-flex justify-content-end">
            <div class="mr-auto p-2"><h3>Synchronize your wishlist</h3></div>
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
         <form method="post" action="{{ url('sync/sync') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label> We want your wishlist to have good data, so think about sync new data from
                        AppliancesDelivered.ie to your wishlist from time to time.  
                </label>                  
            </div>
            <br />
            <div class="form-group">
                    <input type="submit" name="sync" value="Synchronize" class="btn btn-success" />                    
            </div>
        </form> 
    </div>
@endsection