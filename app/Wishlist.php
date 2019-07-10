<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = "wishlist";
	
	protected $fillable = ['article', 'img', 'price', 'reference', 'user_id' ];

	public static function existe($article,$user)  // relaciones: un articulo ya existe en la lista de deseos de ese usuario
	{
		$resultado = Wishlist::where([
			['article', '=', $article],
			['user_id', '=', $user],
			])->first();
			
		return $resultado;
			
	}

	public static function reference($article, $user, $reference)  // relaciones: un articulo ya existe en la lista de deseos de ese usuario
	{
		$resultado = Wishlist::where([
			['article', '=', $article],
			['reference', '=', $reference],
			['user_id', '=', $user],
			])->first();
			
		return $resultado;
			
	}
}
