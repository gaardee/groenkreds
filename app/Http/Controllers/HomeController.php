<?php

namespace App\Http\Controllers;

use App\Kreds;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function kortet()
    {
        $kredse = Kreds::isActive()->get();
        return view('kortet', compact('kredse'));
    }

    public function kreds(Kreds $kreds)
    {
        $kredse = Kreds::isActive()->get();
        return view('kortet', compact('kredse', 'kreds'));
    }

    public function aktiviteter()
    {
        return view('aktiviteter');
    }

    public function om()
    {
        return view('om');
    }
}
