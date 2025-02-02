<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:settings', ['only' => ['index']]);
        // $this->middleware('permission:menu-manage-users', ['only' => ['index','show','create','store','edit','update','destroy']]);
        // $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:user-create', ['only' => ['create','store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(){
        return view('settings.index');
    }
}
