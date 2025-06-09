<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil de l'application.
     */
    public function index()
    {
        return view('welcome'); // Change 'welcome' si ta vue a un autre nom
    }
}
