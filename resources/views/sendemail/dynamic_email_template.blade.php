<p>Hi {{ $data['friend_name'] }},</p>
<br>
<p>Your friend {{ Auth::user()->name }} wants to share with you this amazing wishlist formed with products from our site.</p>
<p>If there is one of those selected products that you would like to delete form the list, feel free to tell.
<p>{{ Auth::user()->name }} wants to tell you: </p>
<p><strong>{{ $data['message'] }} </strong></p>
<table class="table table-striped">
    <thead>
        <th>Article</th>
        <th></th>
        <th>Price</th>
    </thead>
    @foreach($data['wishlist'] as $article)
    <tr>
        <td>{{ $article['article'] }}</td>
        <td>{!! $article['img'] !!}</td>
        <td>{{ $article['price'] }}</td>
        
    </tr>
    @endforeach
</table>
<p>Hope you take some ideas for a birthday present</p>
<br>
<p>Have a great day</p>