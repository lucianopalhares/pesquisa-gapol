<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $questions = \App\Question::all();
        $campaigns = \App\Campaign::all();
        $users = \App\User::all();
        $roles = \App\Role::all();

        return view('home',compact('questions','campaigns','users','roles'));
    }
    public function chart(Question $question)
    {
        $questions = $question::has('campaign_answers')->get();
        return view('chart',compact('questions'));
    }
}
