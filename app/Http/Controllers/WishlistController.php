<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::guest()) {
            $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->get();
            if (count($wishlist) > 0) {
                return view('wishlist.index')->with('wishlist',$wishlist); // enviar variables a otra vista
            } else {
                return back()->with('error', 'Your wishlist is empty, please, select some products');
            }
        } else {
            return back()->with('error', 'You are not logged in');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		
        return view('wishlist/create')
        ->with('article',$request->article)
        ->with('img',$request->img)
        ->with('price',$request->price)
        ->with('reference',$request->reference)
        ->with('user_id', Auth::user()->id)
        ;
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
        $wishlist = new Wishlist();
		$wishlist->article = $request->article;
		$wishlist->img = $request->img;
        $wishlist->price = $request->price;
        $wishlist->reference = $request->reference;
		$wishlist->user_id = Auth::user()->id;
		$wishlist->save();
	
		$contador_wishlist = count(Wishlist::where('user_id', '=', Auth::user()->id)->get());

		return redirect()->back()->with('success', 'Product added to your wishlist')
        ->with('contador_wishlist',$contador_wishlist)
        ->with('existe', true)
		;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function destroy($id)
    {
        $wishlist = Wishlist::find($id);
        $cont= count(Wishlist::where('user_id', '=', Auth::user()->id)->get());
        $ultimo = false;
        if ($cont == 1){ $ultimo = true;}

        $wishlist->delete();
        if ($ultimo) {
             return redirect()->route('search.create');       
        } else {
            return redirect()->route('wishlist.index');
		}
    }
}
