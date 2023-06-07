<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function getLang() {
        return App::getLocale();
    }

    public function setLang($lang){
        Session::put('lang', $lang);
        return redirect()->back();
    }
}
