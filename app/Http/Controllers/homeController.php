<?php

namespace App\Http\Controllers;

use App\prog_test;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index(){
        $artikel = prog_test::all();
        $countArtikel = prog_test::count();
        return view('home')->with('artikel',$artikel)->with('count',$countArtikel);
    }
}
