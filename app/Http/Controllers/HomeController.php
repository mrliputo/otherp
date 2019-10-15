<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nodes;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $nodes = Nodes::where('user_id', auth()->user()->id)->orderByDesc('created_at')->get();
        return view('dashboard')->with('nodes', $nodes);
    }
}
