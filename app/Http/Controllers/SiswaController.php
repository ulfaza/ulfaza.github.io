<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;  
use Excel;
use App\User;
use App\Kelas;
use App\Siswa;

class SiswaController extends Controller
{
    public function index($k_id){
    	$data['no'] = 1;
        $kelas = DB::table('m_kelas')
            ->where('k_id',$k_id)
            ->get();
        $siswa = DB::table('m_siswa')
        	->join('m_kelas', 'm_kelas.k_id', '=', 'm_siswa.k_id')
        	->where('m_siswa.k_id',$k_id)
        	->get();
        $data['kelas'] = $kelas;
        $data['siswa'] = $siswa;  
        return view('/admin/siswa/index',$data);
    }

    function action(Request $request)
    {
        if($request->ajax())
        {
            if($request->action == 'edit')
            {
                $data = array(
                    's_nama'    =>  $request->s_nama,
                    'nis'       =>  $request->nis,
                    'nisn'      =>  $request->nisn,
                    'status'    =>  $request->status
                );
                DB::table('m_siswa')
                    ->where('s_id', $request->s_id)
                    ->update($data);
            }
            if($request->action == 'delete')
            {
                DB::table('m_siswa')
                    ->where('s_id', $request->s_id)
                    ->delete();
            }
            return response()->json($request);
        }
    }

    public function insert($k_id)
    {
        $kelas = DB::table('m_kelas')
            ->where('k_id',$k_id)
            ->get();
        $data['kelas'] = $kelas;
        return view('/admin/siswa/insert',$data);
    }

    public function store(Request $request, $k_id)
    {
        $siswa = new Siswa;
        $siswa->k_id    = $request->k_id;
        $siswa->nis     = $request->nis;
        $siswa->nisn    = $request->nisn;
        $siswa->s_nama  = $request->s_nama;
        $siswa->status  = $request->status;

        if ($siswa->save()){
            return redirect()->route('siswa',$k_id);
        }
        else{
            return redirect()->route('insert.siswa',$k_id);
        } 
    }

    public function import($k_id)  
    {
        $kelas = DB::table('m_kelas')
            ->where('k_id',$k_id)
            ->get();
        $data['kelas'] = $kelas;
        return view('/admin/siswa/import',$data);  
    }

    public function importExcel($k_id)  
    {  
        if(Input::hasFile('import_file')){  
            $path = Input::file('import_file')->getRealPath();  
            $data = Excel::load($path, function($reader) {  
            })->get();  
            if(!empty($data) && $data->count()){  
                foreach ($data as $key => $value) {  
                    $insert[] = ['k_id' => $k_id, 'nis' => $value->nis, 's_nama' => $value->s_nama, 'nisn' => NULL, 'status' => $value->status];  
                }  
                if(!empty($insert)){  
                    DB::table('m_siswa')->insert($insert);  
                    return redirect()->route('kelas');  
                }  
            }  
        }  
        return back();  
    }
}
