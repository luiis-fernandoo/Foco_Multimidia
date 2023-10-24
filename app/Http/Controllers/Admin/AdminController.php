<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('Admin/index');
    }

    public function detailsRoom(string $id){
        return view('Admin/detailsRoom', compact('id'));
    }
}
