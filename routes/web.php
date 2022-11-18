<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post("/registrasi", ['uses' => "RegistrasiController@registrasi"]);
$router->post("/login", ["uses" => "LoginController@login"]);

$router->get("/produk", ["uses" => "ProdukController@get"]);
$router->get("/produk/{id}", ["uses" => "ProdukController@show"]);
$router->post("/produk", ["uses" => "ProdukController@create"]);
$router->patch('/produk/{id}', ["uses" => "ProdukController@update"]);
$router->delete('/produk/{id}', ["uses" => "ProdukController@delete"]);
