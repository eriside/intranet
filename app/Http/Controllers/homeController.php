<?php

namespace App\Http\Controllers;

use App\Models\aktuelles;
use App\Models\fuhrpark;
use App\Models\Leitung;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index(){
        $berichte = aktuelles::all()->sortByDesc('einsatzNummer');

        return view('home', compact('berichte'));
    }

    public function leitung(){
        $mitglieder = Leitung::all();

        return view('leitung', compact('mitglieder'));
    }
    public function fuhrpark(){
        $fuhrpark = fuhrpark::all();
        return view('fuhrpark', compact('fuhrpark'));
    }
}
