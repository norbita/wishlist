@extends('layouts.app')

@section('content')
	
	<div class="card-header">			  
		<div class="d-flex justify-content-end">
			<div class="mr-auto p-2"><h3>Wishlist</h3></div>
			<div class="p-2">				
					{!! Form::open(['route' => 'search.list', 'method' => 'GET']) !!}
					<div class="form-group">	
						{!! Form::submit('Back', ['class' => 'btn btn-info']) !!}
					</div>
				{!! Form::close()  !!}			
			</div>				
		</div>
	</div>

    <div class="card-body">
        <div class="container box">
            <!-- numero de articulos en my wishlist -->
			@if (!Auth::guest())
				@if (count($wishlist) > 0)
				<table>
				<thead>
				<th>
					{!! Form::open(['route' => 'sendemail.index', 'method' => 'GET']) !!}
						<div class="form-group">	
							{!! Form::submit('Share wishlist', ['class' => 'btn btn-warning']) !!}
						</div>
					{!! Form::close()  !!}
				</th>
				<th>
					{!! Form::open(['route' => 'sync.index', 'method' => 'GET']) !!}
						<div class="form-group">	
							{!! Form::submit('Sync wishlist', ['class' => 'btn btn-success']) !!}
						</div>
					{!! Form::close()  !!}
				</th>
				</thead>
				</table>
				@endif
			@endif

	<!-- numero de articulos en my wishlist -->
	<!-- Buscador de articulos -->

	<table class="table table-striped">
		<thead>
			<th>Article</th>
			<th></th>
			<th>Price</th>
			<th></th>
		</thead>	
		<tbody>
			@foreach($wishlist as $article)
				<tr>
					<td>{{ $article['article'] }}</td>
					<td>{!! $article['img'] !!}</td>
					<td>{{ $article['price'] }}</td>
					
					<td>
						<a href="{{ route('wishlist.destroy',$article->id) }}" onclick="return confirm('¿Seguro deseas eliminar el registro?')" class="btn btn-danger"><span>{{ 'Delete' }}</span></a>
					</td>
					
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection