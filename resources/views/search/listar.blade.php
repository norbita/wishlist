@extends('layouts.app')

@section('title', 'Inventory list')

@section('content')

	<div class="card-header"><h3>Search</h3></div>
	<div class="card-body">
		<div class="container box">
			<div class="panel-body">
				<div class="d-flex justify-content-end">
					<div class="mr-auto p-2"><strong>{{ $category}}</strong>{{", ".$order  }}</div>
					<div class="p-2">				
						@if (!Auth::guest())
							{!! Form::open(['route' => 'wishlist.index', 'method' => 'GET', 'class' => 'navbar-form text-right']) !!}
								<div class="form-group">	
										{!! Form::submit('My wishlist '.'('.$contador_wishlist.')', ['class' => 'btn btn-warning']) !!}
								</div>
							{!! Form::close()  !!}
						@endif		
					</div>				
				</div>

				<table class="table table-striped">
					<thead>
						<th>Article</th>
						<th></th>
						<th>Price</th>
						@if (!Auth::guest())
							<th>Add to wishlist</th>
						@endif	
					</thead>	
					<tbody>
						@if ($articles)
						@foreach($articles as $article)
							<tr>
								<td>{{ $article['article'] }}</td>
								<td>{!! $article['img'] !!}</td>
								<td>{{ $article['price'] }}</td>
							@if (!Auth::guest())
								@if (App\Wishlist::existe($article['article'], Auth::user()->id))
									<td><span>Added</span></td>
								@else
								<td>
									<a href="{{ route('search.add',$article) }}" 
									onclick="return confirm('¿Seguro deseas agregar al wishlist?')" 
									class="btn btn-info"><span>{{ 'Add' }}</span></a>						

								</td>
								@endif
							@endif		
							</tr>
						@endforeach
						@endif
					</tbody>
				</table>									
			</div>
		</div>
	</div>
@endsection