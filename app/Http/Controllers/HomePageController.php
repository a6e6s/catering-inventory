<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function locale($locale)
    {
        // Set the locale in the session
        $locale = in_array($locale, ['en', 'ar']) ? $locale : 'en';
        session(['locale' => $locale]);
        app()->setLocale($locale);
        // Redirect back to the previous page
        return redirect()->back();
    }
}
