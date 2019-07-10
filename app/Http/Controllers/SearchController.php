<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Wishlist;
use App\Http\Requests;

class SearchController extends Controller
{
	protected $art;
    public function create()
    {
        $contador_wishlist = 0;
        if (!Auth::guest()) {
            $contador_wishlist = count(Wishlist::where('user_id', '=', Auth::user()->id)->get());
		}
        return view('search.create')
		->with('contador_wishlist',$contador_wishlist)
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
		$category = $request->category;
		switch ($category) {
			case 1:
				$url= 'https://www.appliancesdelivered.ie/dishwashers';
				$category = "Dishwashers";
				break;
			case 2:
				$url= 'https://www.appliancesdelivered.ie/small-appliances';
				$category = "Small Appliances";
				break;
			case 3:
				$url= 'https://www.appliancesdelivered.ie/fridges-and-freezers';
				$category = "Refrigeration & Cooling Appliances";
				break;
			case 4:
				$url= 'https://www.appliancesdelivered.ie/garden-diy';
				$category = "Garden & DIY";
				break;	
			default:
				$url= 'https://www.appliancesdelivered.ie/dishwashers';
				$category = "Dishwashers";	
		}

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);

		if ($output) {
			$etiqueta = 'search-results-product';
			$tag = 'data-src="';
			$tag_nombre = 'https://www.appliancesdelivered.ie/';
			$end_nombre = "'>";
			$alt = 'alt="';
			$money = 'section-title">€';
			$bracket = "<";
			$price_tag = "section-title";
			$end = '"';
			$price = 0;
			$arreglo = array();
			$reference = $url;
			
			$notes = explode("\n", $output);
			$contador = count($notes);

			$en_producto = false;
			$hay = false;

			for ($i=0; $i < $contador; $i++) {
				if (strpos($notes[$i], $etiqueta) !== false) { // comienza grupo del producto
					$en_producto = true;
					$line = null;
					while ($en_producto) {
						$line .= $notes[$i];
						if (strpos($notes[$i], $tag_nombre) !== false) { // encuentra el nombre del producto
							$pos = stripos($line, $tag_nombre); // encuentra el tag
							$str = substr($line, $pos);	
							$str_two = substr($str, strlen($tag_nombre));
							$second_pos = stripos($str_two, $end_nombre);
							$artic = substr($str_two, 0, $second_pos);
							$article = str_replace("-"," ","$artic");
							$aux = explode(' ',$article);
							$code = array_pop($aux);
							//echo "<br>".'Articulo: '.htmlspecialchars($article)."<br>";
						}	
						if (strpos($notes[$i], $tag) !== false) { // encuentra la imagen 
							$pos = stripos($line, $tag); 
							$str = substr($line, $pos);	
							$str_two = substr($str, strlen($tag));
							$second_pos = stripos($str_two, $end);
							$image = '<img src="';
							$image .= substr($str_two, 0, $second_pos);
							$image .= '">';
						}

						if (strpos($notes[$i], $price_tag) !== false) { // encuentra el tag
							$pos = stripos($line, $money); // encuentra el precio oferta
							$str = substr($line, $pos);	
							$str_two = substr($str, strlen($money));
							$second_pos = stripos($str_two, $bracket);
							$price = substr($str_two, 0, $second_pos);
							$hay = true; // existe algun producto
							$en_producto = false; // finalice los datos del producto
						}
						$i++;
					}
				}

				$contador_wishlist = 0;
				$existe =false;	
				if (!Auth::guest()) {
					$contador_wishlist = count(Wishlist::where('user_id', '=', Auth::user()->id)->get());							
				} 

				if ($hay) {
					if (!Auth::guest()) {
						if (Wishlist::existe($article, Auth::user()->id)) {
							$existe = true;
						} 
					}
					$arreglo[] = array(
						'article' => $article, 
						'img' => $image, 
						'price' => $price, 
						'reference' => $url,
						'existe' => $existe
						);
					$price = 0; 
					$hay = false;	
				}
			}

			$cont = count($arreglo);
			$sort = array();
			if ($cont > 0) {
				if ($request->order == 2) {
					$order = "order by title";
					foreach($arreglo as $k=>$v) {
						$sort['article'][$k] = $v['article'];
					}
					array_multisort($sort['article'], SORT_ASC, $arreglo);					
				} else {
					foreach($arreglo as $k=>$v) {
						$sort['price'][$k] = $v['price'];
					}
					if ($request->order == 0) {
						$order = "cheapest products";
						array_multisort($sort['price'], SORT_ASC, $arreglo);						
					} else {
						$order = "most expensive products";
						array_multisort($sort['price'], SORT_DESC, $arreglo);						
					}
				}
				$articles  = array_slice($arreglo,0,$cont);
			} else { 
				$articles = array();
				$contador_wishlist = 0;
				$order = "No hay productos en la lista";
			}

		} else { 
			$articles = array();
			$contador_wishlist = 0;
			$order = "No leyo la pagina";
		}

		Session::put('art', $articles);
		Session::put('order', $order);
		Session::put('category', $category);

		return view ('search.listar')
		->with('articles',$articles)
		->with('order',$order)
		->with('category',$category)
		->with('contador_wishlist',$contador_wishlist)
		;
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
	
		$wishlist = new Wishlist();
		$wishlist->article = $request->article;
		$wishlist->img = $request->img;
        $wishlist->price = $request->price;
        $wishlist->reference = $request->reference;
		$wishlist->user_id = Auth::user()->id;
		$wishlist->save();
	
		$contador_wishlist = count(Wishlist::where('user_id', '=', Auth::user()->id)->get());
		$articles = Session::get('art');
		$order = Session::get('order');
		$category = Session::get('category');

		return view('search.listar')
		->with('articles',$articles)
		->with('order',$order)
		->with('category',$category)
		->with('contador_wishlist',$contador_wishlist)
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
     * List the elements from thespecified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
		$contador_wishlist = count(Wishlist::where('user_id', '=', Auth::user()->id)->get());
		$articles = Session::get('art');
		$order = Session::get('order');
		$category = Session::get('category');

		return view('search.listar')
		->with('articles',$articles)
		->with('order',$order)
		->with('category',$category)
		->with('contador_wishlist',$contador_wishlist)
		;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
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
        //
    }
}
