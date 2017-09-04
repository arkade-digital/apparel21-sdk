<?php

Route::get('/', function () { return redirect()->to('/shopify/install'); });

Route::prefix('shopify')->middleware('shopify-context')->namespace('App\\Shopify\\Controllers')->group(function ()
{
    Route::get('/', function () { return redirect()->to('/shopify/install'); });
    Route::get('install', 'AuthController@install');

    Route::middleware('shopify-request')->group(function () {
        Route::get('authorize', 'AuthController@auth');

        Route::middleware('shopify-installed')->group(function () {
            Route::get('app', 'AppController@app');
            Route::post('webhook', 'WebhookController@receive');
        });
    });
});
