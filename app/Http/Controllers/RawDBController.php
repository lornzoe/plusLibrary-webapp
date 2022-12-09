<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RawDBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // we'll relook this in the future, for now we have a reliable way of pulling the db. 
        // use heidisql or smth to convert the needed data to a csv or any relevant data.
        // we're only allowing this because we don't intend to put 
        return response()->download(database_path('database.sqlite'), "db_backup.sqlite");

        // return "NIL. Controller code should be modified."
    }
}
