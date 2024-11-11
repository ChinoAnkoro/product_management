<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TetrisController extends Controller
{
    public function index()
    {
        return view('products.tetris');
    }
}
