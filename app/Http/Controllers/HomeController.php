<?php

namespace App\Http\Controllers;

use Illuminate\Cache\RetrievesMultipleKeys;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  // public function index(){
  //   return view('admin/index');
  // }

  public function frontend(){
    return view('frontend.frontend_index');
  }

  public function about(){
    return view('frontend.about');
  }

  public function shop(){
    return view('frontend.shop');
  }

  public function faq(){
    return view('frontend.faq');
  }
  public function contact(){
    return view('frontend.contact');
  }

}
