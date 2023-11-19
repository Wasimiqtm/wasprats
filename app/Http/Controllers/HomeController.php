<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        return view('home');
    }
    
    public function about ()
    {
        return view('about');
    }
    
    public function services ()
    {
        return view('services');
    }
    
    public function faq ()
    {
        return view('faq');
    }
    
    public function contact ()
    {
        return view('contact');
    }
    
    public function careers ()
    {
        return view('careers');
    }
    
    public function blog ()
    {
        return view('blog');
    }
}
