<?php

namespace App\Http\Controllers;

use App\Models\Aktivitet;
use App\Models\Kreds;
use App\Models\Page;

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

    public function aktiviteter(?Aktivitet $aktivitet = null)
    {
        $all = Aktivitet::all()->groupBy('type');
        $aktiviteter = [];
        for ($i = 0; $i < max(count($all[1] ?? []), count($all[2] ?? []), count($all[3] ?? [])); $i++) {
            array_push($aktiviteter, $all[1][$i] ?? null);
            array_push($aktiviteter, $all[2][$i] ?? null);
            array_push($aktiviteter, $all[3][$i] ?? null);
        }
        $slug = $aktivitet->slug ?? null;
        return view('aktiviteter', compact('aktiviteter', 'aktivitet', 'slug'));
    }

    public function page(Page $page)
    {
        return view('page', compact('page'));
    }
}
