<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class DashboardController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
    	$count = User::where('estado_id', '!=', 2)->where('id', '!=', 1)->count();

    	//dd($count);
  
        return view('dashboard', ['count' => $count]);
    }
}
