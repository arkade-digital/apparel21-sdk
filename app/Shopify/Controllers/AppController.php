<?php

namespace App\Shopify\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    /**
     * Render the app.
     *
     * @return Response
     */
    public function app()
    {
        return view('shopify::app');
    }
}
