<?php

namespace App\Http\Controllers;

class ExampleController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}
	public function products() {

		$object = array();
		$r = array();
		for ($i = 0; $i < 20; $i++) {
			$r['thumbnailImage'] = "logo.php";
			$r['name'] = "Product " . $i;
			$r['modelNumber'] = "PROD-" . $i;
			$r['upc'] = "upc " . time();
			$r['standardShipRate'] = "Address " . $i;
			$r['salePrice'] = 2 * $i;
			$r['sellerInfo'] = "seller Info "+$i;
			$r['stock'] = 3 * $i;
			$r['productUrl'] = "productUrl "+$i;
			$object[] = $r;
		}

		return response()->json($object);
	}
	//
}
