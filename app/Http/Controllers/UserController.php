<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;  
use Excel;
use App\User;

class UserController extends Controller
{
    public function guru(){
        $data['no'] = 1;
        $guru = DB::table('users')
        	->where('role', "guru")
        	->get();
        $data['guru'] = $guru;
        return view('/admin/pengguna/guru/index',$data);
    }

    public function insert()
    {
        return view('/admin/pengguna/guru/insert');
    }

    public function store(Request $request)
    {
      $guru = new User;
      $guru->nama     	= $request->nama;
      $guru->username  	= $request->username;
      $guru->foto     	= NULL;
      $guru->role     	= "guru";
      $guru->password   = bcrypt($request->password);

      if ($guru->save()){
        return redirect('/admin/daftar/guru');
      }
      else{
        return redirect('/admin/tambah/guru');
      }
    }

    public function edit($id)
    {
        $guru = DB::table('users')
        	->where('id',$id)
        	->get();
        $data['guru'] = $guru;
        return view('/admin/pengguna/guru/edit',$data);
    }

    public function update(Request $request, $id){
        DB::table('users')->where('id',$id)->update([
            'nama'      => $request->nama,
            'username'  => $request->username
        ]);           
      	return redirect()->route('list.guru');
    }

    public function delete($id){
        $guru = User::findOrFail($id)->delete();
        return redirect()->route('list.guru');
    }

    public function import()  
    {  
        return view('/admin/pengguna/guru/import');  
    }

    public function importExcel()  
    {  
        if(Input::hasFile('import_file')){  
            $path = Input::file('import_file')->getRealPath();  
            $data = Excel::load($path, function($reader) {  
            })->get();  
            if(!empty($data) && $data->count()){  
                foreach ($data as $key => $value) {  
                    $insert[] = [
                    	'nama' => $value->nama, 
                    	'username' => $value->username, 
                    	'foto' => NULL,
                    	'role' => "guru",
                    	'password' => bcrypt($value->password)
                    ];  
                }  
                if(!empty($insert)){  
                    DB::table('users')->insert($insert);  
                    return redirect()->route('list.guru');  
                }  
            }  
        }  
        return back();  
    }
}
