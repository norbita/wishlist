<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use Auth;

class SyncWishlistController extends Controller
{
    function index() {
        return view('sync.sync');
    }

    function sync(Request $request)
    {
        if (!Auth::guest()) {

            $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->orderBy('reference')->get();
            $contador = count($wishlist);
            $aux_reference = "xxx";
            $money = 'section-title">€';
            $bracket = "<";
            $arreglo = array();
			$price = 0;

            if ($contador > 0) {
                foreach($wishlist as $article) {
                    $aux = explode(' ',$article['article']);
                    $code = array_pop($aux); // codigo del articulo
                    if ($aux_reference != $article['reference']){  // lee la pagina
                        $aux_reference = $article['reference'];            
                        $url = $article['reference'];
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $output = curl_exec($ch);
                        curl_close($ch);
                        $notes = explode("\n", $output);
                        $contador = count($notes);
                    }
                                       
                    $en_producto = false;
                    set_time_limit(1000);
                    if ($output) {         
                        for ($i=0; $i < $contador; $i++) {                            
                            if (strpos($notes[$i], $code) !== false) { // encuentra el producto en url
                                $en_producto = true;
                                $line = null;
                                while ($en_producto) {
                                    $line .= $notes[$i];
                                    if (strpos($notes[$i], $money) !== false) { // encuentra el precio
                                        $pos = stripos($line, $money); // encuentra el precio oferta
                                        $str = substr($line, $pos);	
                                        $str_two = substr($str, strlen($money));
                                        $second_pos = stripos($str_two, $bracket);
                                        $price = substr($str_two, 0, $second_pos);
                                        $en_producto = false; // finalice los datos del producto
                                        $i = $contador;
                                                                         
                                        $arreglo[] = array(
                                            'article' => $article['article'], 
                                            'img' => $article['img'], 
                                            'price' => $article['price'], 
                                            'new_price' => $price,
                                            'reference' => $url
                                        );
                                        if ($article['price'] <> $price){
                                            $updateList = Wishlist::whereId($article['id'])->update(['price' => $price]);
                                        }
                                    }
                                    $i++;
                                }
                            }                            
                        }
                    } else {
                        return back()->with('error', 'No leyo la pagina');
                    }
                }
                $cont = count($arreglo);
                $articles  = array_slice($arreglo,0,$cont);
                return view ('sync.list')
                ->with('articles',$articles)
                ->with('success', 'Your wishlist was synchronized')
                ;

            } else {
                return back()->with('error', 'Your wishlist is empty, please, select some products');
            }
        } else {
            return back()->with('error', 'You are not logged in');
        }
    }
}
