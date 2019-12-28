<?php

namespace App\Http\Controllers;

use App\Kreds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KredsController extends Controller
{
    public function edit($key)
    {
        $kreds = Kreds::where('key', $key)->first();

        return view('kreds.edit', compact('kreds'));
    }


    public function rules()
    {
        $rules = [
            'name' => 'required'
        ];
        $photos = count($this->input('photos'));
        foreach (range(0, $photos) as $index) {
            $rules['photos.' . $index] = 'image|mimes:jpeg,bmp,png|max:2000';
        }

        return $rules;
    }

    public function update(Request $request, $key)
    {
        $kreds = Kreds::where('key', $key)->first();
        $kreds->kontakt_email = $request->kontakt_email;
        $kreds->kontakt_navn = $request->kontakt_navn;
        $kreds->motivation = $request->motivation;
        $kreds->active = 1;

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
