<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Redirect shop subdomain to external merch store
     */
    public function redirect()
    {
        return redirect()->away('https://exclaim.gg/store/odyssey-clan');
    }
}