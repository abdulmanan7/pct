<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$app->get('/', function () use ($app) {
	return "hello world";
});

$app->get('api/get_products', 'ApiController@get_products');
$app->get('api/get_product_detail/{keyword}', 'ApiController@get_product_detail');
$app->get('api/products', 'ApiController@products');
// $app->get('api/products', 'ExampleController@products');