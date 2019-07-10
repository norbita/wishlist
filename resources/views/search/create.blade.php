@extends('layouts.app')

@section('content')

    <div class="card-header">Search</div>

    <div class="card-body">
        <div class="container box">
            <!-- numero de articulos en my wishlist -->
            @if (!Auth::guest())
                {!! Form::open(['route' => 'wishlist.index', 'method' => 'GET', 'class' => 'navbar-form text-right']) !!}
                    <div class="form-group">	
                        {!! Form::submit('My wishlist'.' ('.$contador_wishlist.') ', ['class' => 'btn btn-warning']) !!}
                    </div> 
                {!! Form::close()  !!}
            @endif

            <div class="panel-body">
                {!! Form::open(['route' => 'search.store', 'method' => 'POST']) !!}
                    <div class="col-md-6">
                        <div class="checkbox">                              
                            <br/>
                            <h3>Category</h3><br/>
                            <input type="radio" id="cat1" name="category"  value="1" checked="checked"/>
                            <span></span>Dishwashers
                            <br/>
                            <input type="radio" id="cat2" name="category" value="2" />
                            <span></span>Small Appliances
                            <br/>
                            <input type="radio" id="cat3" name="category"  value="3"/>
                            <span></span>Refrigeration & Cooling Appliances
                            <br/>
                            <input type="radio" id="cat4" name="category"  value="4"/>
                            <span></span>Garden & DIY
                            <br/>
                        </div>
                        <br>
                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox">                              
                                    <br/>
                                    <label>Order:</label><br/>
                                    <input type="radio" id="radio02" name="order"  value="0" checked="checked"/>
                                    <span></span>cheapest products
                                    <br/>
                                    <input type="radio" id="radio03" name="order" value="1" />
                                    <span></span>most expensive products
                                    <br/>
                                    <input type="radio" id="radio01" name="order"  value="2"/>
                                    <span></span>title
                                    <br/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">	
                            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
                        </div>                        
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection