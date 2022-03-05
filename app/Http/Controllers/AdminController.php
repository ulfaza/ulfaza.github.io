<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class AdminController extends Controller
{
    //
    public function index(){
    	return view('admin/home');
    }

    public function edit($id)
    {
        // mengambil data users berdasarkan id yang dipilih
        $users = DB::table('users')->where('id',$id)->get();
        // passing data admin yang didapat ke view edit_profil.blade.php
        return view('/admin/edit_profil',['users' => $users]);
    }

    public function update(Request $request, $id){
        DB::table('users')->where('id',$request->id)->update([
            'nama' => $request->nama,
            'email' => $request->email
        ]);           
      	return redirect()->route('adminhome');
    }
}
