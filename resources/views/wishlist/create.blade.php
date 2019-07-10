@extends('layouts.app')

@section('content')

    <div class="card-header"><h3>Add to wishlist</h3></div>

    <div class="card-body">
        <div class="container box">

			{!! Form::open(['route' => 'wishlist.store', 'method' => 'POST']) !!}

				
				<div class="form-group">
					{!! Form::text('article', $article, ['class' => 'form-control', 'readonly' => 'true']) !!}
					{!! Form::hidden('img', $img ) !!}
					{!!  $img !!}
				</div>
				
				<div class="form-group">
					{!! Form::label('title', 'Price') !!}
					{!! Form::text('price', $price, ['class' => 'form-control', 'readonly' => 'true']) !!}
				</div>

				<div class="form-group">
						{!! Form::label('reference', 'Referencia') !!}
						{!! Form::text('reference', $reference, ['class' => 'form-control', 'readonly' => 'true']) !!}
					</div>

				<div class="form-group">	
					{!! Form::submit('Add', ['class' => 'btn btn-primary']) !!}
				</div>					
				
			{!! Form::close() !!}
        </div>			
	</div>
@endsection