<?php

namespace App\Http\Controllers;

use App\Models\Aktivitet;
use App\Models\Kreds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KredsController extends Controller
{
    public function edit($key)
    {
        $kreds = Kreds::where('key', $key)->first();

        $aktiviteter = Aktivitet::orderBy('type')->get();

        abort_if(! $kreds, 404);

        return view('kreds.edit', compact('kreds', 'aktiviteter'));
    }

    public function update(Request $request, $key)
    {
        // dd($request);
        $kreds = Kreds::where('key', $key)->firstOrFail();
        $kreds->kontakt_email = $request->kontakt_email;
        $kreds->kontakt_navn = $request->kontakt_navn;
        $kreds->motivation = $request->motivation;
        $kreds->active = 1;

        $kreds->aktiviteter()->sync($request->aktiviteter);

        $billeder = $kreds->billeder ?? [];
        // dd($request->photos);
        if ($request->photos) {
            foreach ($request->photos as $photo) {
                preg_match("/^data:image\/(\w*);base64,/", $photo, $ext);
                $filename = md5(uniqid()) . '.' . $ext[1];
                Storage::disk('public')->put('photos/' . $filename,  base64_decode(explode(',', $photo)[1]));
                array_push($billeder, $filename);
            }
        }
        if ($request->removePhotos) {
            foreach (json_decode($request->removePhotos) as $remove) {
                if (($key = array_search($remove, $billeder)) !== false) {
                    unset($billeder[$key]);
                }
            }
        }
        $kreds->billeder = array_values($billeder);
        $kreds->save();

        return redirect(route('kreds.edit', $kreds->key));
    }
}
