@extends('layouts.app')

@section('content')

    <div class="card-header">Wishlist Synchronized</div>

    <div class="card-body">
        <div class="container box">

	        <!-- Buscador de articulos -->

            <table class="table table-striped">
                <thead>
                    <th>Article</th>
                    <th></th>
                    <th>Price</th>
                    <th>Updated Price</th>
                    <th></th>
                </thead>	
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article['article'] }}</td>
                            <td>{!! $article['img'] !!}</td>
                            <td>{{ $article['price'] }}</td>
                            
                                @if ($article['price'] <> $article['new_price'])
                                    <td class="p-3 mb-2 bg-danger text-white">{{ $article['new_price'] }}</td>
                                @else
                                    <td>{{ $article['new_price'] }}</td> 
                                @endif                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection