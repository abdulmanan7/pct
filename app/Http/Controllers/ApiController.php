<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ApiController extends Controller {

	public function products(Request $request) {

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
		if ($request->ajax()) {
			return response()->json($object);
		} else {
			return view('products', ['products' => $object]);

		}
	}

	public function get_products(Request $request) {
		$query = $request->input('query');
		$querydecoded = urldecode($query);
		$queryParts = explode("?", $querydecoded);
		$paramParts = explode("=", $queryParts[1]);
		$qParts = explode("&", $paramParts[2]);
		$q = $qParts[0];
		// print_r($paramParts);
		$from_price = $request->input('from_price');
		$to_price = $request->input('to_price');
		$salesRank = $request->input('salesRank');
		$searchIndex = $request->input('searchIndex', 'All');
		$responseGroup = $request->input('responseGroup', 'Large');
		$params = array('SearchIndex' => $searchIndex, 'ResponseGroup' => $responseGroup);
		if ($from_price) {
			$params['MaximumPrice'] = $from_price;
		}
		if ($to_price) {
			$params['MinimumPrice'] = $to_price;
		}
		if (is_numeric($q)) {
			$params['BrowseNode'] = $q;
			$params['SearchIndex'] = "";
		} else {
			$params['Keywords'] = $q;
		}
		$result = aws_query($params);
		$res = parse($result);
		// $json = Formatter::make($result, Formatter::XML); //$formatter->toJson($result);
		$items = json_decode($res, TRUE);
		$items = $items['Items'];
		// Items
		// return response()->json($items);
		$object = array();
		$r = array();
		// print_r($items);die;
		if (count($items) && is_array($items)) {
			foreach ($items['Item'] as $key => $item) {
				$r['salesRank'] = isset($item['SalesRank']) ? $item['SalesRank'] : "";
				$r['thumbnailImage'] = isset($item['SmallImage']['URL']) ? $item['SmallImage']['URL'] : "";
				$r['name'] = isset($item['ItemAttributes']['Title']) ? $item['ItemAttributes']['Title'] : "";
				$r['modelNumber'] = isset($item['ItemAttributes']['Model']) ? $item['ItemAttributes']['Model'] : "";
				$r['upc'] = isset($item['ItemAttributes']['UPC']) ? $item['ItemAttributes']['UPC'] : "";
				$r['standardShipRate'] = "Address ";
				// $r['salePrice'] = $item['Offers']['Offer']['OfferListing']['SalePrice']['FormattedPrice'];
				$r['price'] = isset($item['Offers']['Offer']['OfferListing']['Price']['FormattedPrice']) ? $item['Offers']['Offer']['OfferListing']['Price']['FormattedPrice'] : "";
				$r['listPrice'] = isset($item['ItemAttributes']['ListPrice']['FormattedPrice']) ? $item['ItemAttributes']['ListPrice']['FormattedPrice'] : "";
				$r['sellerInfo'] = "seller Info ";
				$r['stock'] = 3 * 12;
				$r['productUrl'] = $item['DetailPageURL'];
				$object[] = $r;
			}
		}
		return response()->json($object);

	}
	public function get_product_detail($keyword = "") {
		$q = $keyword;
		$api = "zg2erxpzrtcs3d68uaee5hu4";
		$product_lookup_url = "http://api.walmartlabs.com/v1/items/12417832?apiKey={$api}&format=json";
		$url = "http://api.walmartlabs.com/v1/search?apiKey={$api}&query=" . $q;
		$result = call_api($url);
		$result = json_decode($result);
		if (isset($result->items[0])) {
			$data['walmart'] = $result->items[0];
			return response()->json($data);
		} else {
			$data['walmart'] = array(
				'thumbnailImage' => "",
				'name' => "",
				'stock' => "",
				'customerRating' => "",
				"salePrice" => "",
			);
			return response()->json($data);
		}
		// print_r($data);die;
	}

}