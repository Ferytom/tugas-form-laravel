<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class FormController extends Controller
{
    public function index()
    {
        return view('form');
    }

    public function show(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc',
            'image' =>  'required|max:2048|mimes:jpg,jpeg,png',
            'double' => 'required|numeric|between:2.50,99.99',
            'password' =>  ['required', Password::min(8)->mixedCase()->numbers()]
        ]);

        $request->image->storeAs('public/images', $request->image->getClientOriginalName());

        $results =  [
            'name' => $request->name,
            'email' => $request->email,
            'double' => $request->double,
            'password' => $request->password,
            'image' => $request->image->getClientOriginalName()
        ];

        return redirect('/result')->with(['results' => $results, 'success' => 'Data berhasil dikirim']);
    }

    public function result()
    {
        $results = session()->get('results');

        return view('result', [
            'results' => $results
        ]);
    }
}
