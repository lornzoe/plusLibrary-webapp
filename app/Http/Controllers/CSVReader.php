<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CSVReader extends Controller
{
    public function index()
    {
        // a
        return Inertia::render('CSVReader/Index',[
        ]);
    }
}
