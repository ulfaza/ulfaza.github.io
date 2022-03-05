<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Kelas;
use App\Siswa;
use App\Kh;
use App\ThAjar;
use App\UjiKh;
use App\RekapKh;

class GuruController extends Controller
{
    public function index(){
        $datauji = DB::table('uji_kh')
            ->join('m_kelas', 'm_kelas.k_id', '=', 'uji_kh.k_id')
            ->join('m_th_ajar', 'm_th_ajar.ta_id', '=', 'uji_kh.ta_id')
            ->join('m_kh', 'm_kh.kh_id', '=', 'uji_kh.kh_id')
            ->where('uji_kh.penguji', Auth::user()->nama)
            ->orWhere('uji_kh.penguji_laju', Auth::user()->nama)
            ->where('m_th_ajar.status', "AKTIF")
            ->get();   
        $walikelas = DB::table('m_kelas')
            ->join('users', 'users.id', '=', 'm_kelas.wali')
            ->where('users.nama', Auth::user()->nama)
            ->where('m_kelas.tingkat', '!=', 13)
            ->get();
        $data['datauji'] = $datauji;
        $data['walikelas'] = $walikelas;
    	return view('guru/home', $data);
    }

    public function edit($id)
    {
        // mengambil data users berdasarkan id yang dipilih
        $users = DB::table('users')->where('id',$id)->get();
        // passing data admin yang didapat ke view edit_profil.blade.php
        return view('/guru/edit_profil',['users' => $users]);
    }

    public function update(Request $request, $id){
        DB::table('users')->where('id',$request->id)->update([
            'nama' => $request->nama
        ]);           
      	return redirect()->route('guruhome');
    }

    public function kelas($k_id){
        $th_ajar = DB::table('m_th_ajar')
              ->where('m_th_ajar.status', "AKTIF")
              ->get();
        foreach ($th_ajar as $ta) {
            $id_th_ajar = $ta->ta_id;
        }
        $kelas = DB::table('m_kelas')
              ->where('k_id',$k_id)
              ->get();
        $kh = DB::table('uji_kh')
            ->join('m_kh', 'm_kh.kh_id', '=', 'uji_kh.kh_id')
            ->where('uji_kh.ta_id',$id_th_ajar)
            ->where('uji_kh.k_id',$k_id)
            ->select('m_kh.kh_nama')
            ->get();
        // foreach ($kh as $khs) {
        //     for ($i=0; $i < count($kh); $i++) { 
        //         $k[i] = $kh[i]->kh_nama;
        //         dd($k[i]);
        //     }
        // }
        $siswa = DB::table('m_siswa')
            ->where('k_id', $k_id)
            ->select('s_nama', 'nis', 'status')
            ->get();
        $rekapkh = DB::table('rekap_kh')
            ->join('uji_kh', 'uji_kh.uji_id', '=', 'rekap_kh.uji_id')
            ->join('m_siswa', 'm_siswa.s_id', '=', 'rekap_kh.s_id')
            ->join('m_th_ajar', 'm_th_ajar.ta_id', '=', 'uji_kh.ta_id')
            ->join('m_kh', 'm_kh.kh_id', '=', 'uji_kh.kh_id')
            ->where('uji_kh.ta_id',$id_th_ajar)
            ->where('uji_kh.k_id',$k_id)
            ->select('m_kh.kh_nama', 'm_siswa.s_nama', 'rekap_kh.kriteria')
            ->get();
        $datauji = DB::table('uji_kh')
            ->join('m_kelas', 'm_kelas.k_id', '=', 'uji_kh.k_id')
            ->join('m_th_ajar', 'm_th_ajar.ta_id', '=', 'uji_kh.ta_id')
            ->join('m_kh', 'm_kh.kh_id', '=', 'uji_kh.kh_id')
            ->where('uji_kh.penguji', Auth::user()->nama)
            ->orWhere('uji_kh.penguji_laju', Auth::user()->nama)
            ->where('m_th_ajar.status', "AKTIF")
            ->get();    
        $walikelas = DB::table('m_kelas')
            ->join('users', 'users.id', '=', 'm_kelas.wali')
            ->where('users.nama', Auth::user()->nama)
            ->where('m_kelas.tingkat', '!=', 13)
            ->get();
            
        $data['datauji'] = $datauji;
        $data['walikelas'] = $walikelas;
        $data['no'] = 1;
        $data['th_ajar'] = $th_ajar;
        $data['kelas'] = $kelas;
        $data['kh'] = $kh;
        $data['siswa'] = $siswa;
        $data['rekapkh'] = $rekapkh;

        return view('/guru/wali/index',$data);
    }

    public function rekap($uji_id)
    {
        $kh = DB::table('m_kh')
            ->join('uji_kh', 'uji_kh.kh_id', '=', 'm_kh.kh_id')
            ->where('uji_kh.uji_id',$uji_id)
            ->get();

        foreach ($kh as $khs) {
            $aspek1 = $khs->aspek1;
            $aspek2 = $khs->aspek2;
            $aspek3 = $khs->aspek3;
            $aspek4 = $khs->aspek4;
            $max_a1 = $khs->max_a1;
            $max_a2 = $khs->max_a2;
            $max_a3 = $khs->max_a3;
            $max_a4 = $khs->max_a4;
        }

        $cek = DB::table('uji_kh')
            ->where('uji_id',$uji_id)
            ->get();

        foreach ($cek as $c) {
            if ($c->penguji == Auth::user()->nama) {
                $rekapkh = DB::table('rekap_kh')
                    ->join('m_siswa', 'm_siswa.s_id', '=', 'rekap_kh.s_id')
                    ->where('rekap_kh.uji_id',$uji_id)
                    ->where('m_siswa.status',"MUKIM")
                    ->get();
            }
            if ($c->penguji_laju == Auth::user()->nama) {
                $rekapkh = DB::table('rekap_kh')
                    ->join('m_siswa', 'm_siswa.s_id', '=', 'rekap_kh.s_id')
                    ->where('rekap_kh.uji_id',$uji_id)
                    ->where('m_siswa.status',"LAJU")
                    ->get();
            }
        }

        $ujikh = DB::table('uji_kh')
            ->join('m_kelas', 'm_kelas.k_id', '=', 'uji_kh.k_id')
            ->join('m_th_ajar', 'm_th_ajar.ta_id', '=', 'uji_kh.ta_id')
            ->join('m_kh', 'm_kh.kh_id', '=', 'uji_kh.kh_id')
            ->where('uji_kh.uji_id',$uji_id)
            ->get();

        $datauji = DB::table('uji_kh')
            ->join('m_kelas', 'm_kelas.k_id', '=', 'uji_kh.k_id')
            ->join('m_th_ajar', 'm_th_ajar.ta_id', '=', 'uji_kh.ta_id')
            ->join('m_kh', 'm_kh.kh_id', '=', 'uji_kh.kh_id')
            ->where('uji_kh.penguji', Auth::user()->nama)
            ->orWhere('uji_kh.penguji_laju', Auth::user()->nama)
            ->where('m_th_ajar.status', "AKTIF")
            ->get();

        $walikelas = DB::table('m_kelas')
            ->join('users', 'users.id', '=', 'm_kelas.wali')
            ->where('users.nama', Auth::user()->nama)
            ->where('m_kelas.tingkat', '!=', 13)
            ->get();

        $data['ujikh'] = $ujikh;
        $data['kh'] = $kh;
        $data['uji_id'] = $uji_id;
        $data['aspek1'] = $aspek1;
        $data['aspek2'] = $aspek2;
        $data['aspek3'] = $aspek3;
        $data['aspek4'] = $aspek4;
        $data['max_a1'] = $max_a1;
        $data['max_a2'] = $max_a2;
        $data['max_a3'] = $max_a3;
        $data['max_a4'] = $max_a4;
        $data['rekapkh'] = $rekapkh;
        $data['datauji'] = $datauji;
        $data['walikelas'] = $walikelas;
        return view('/guru/rekapkh/index', $data);
    }

    function updatenilai(Request $request, $r_id, $uji_id)
    {
        $kh = DB::table('m_kh')
            ->join('uji_kh', 'uji_kh.kh_id', '=', 'm_kh.kh_id')
            ->where('uji_kh.uji_id',$uji_id)
            ->get();

        foreach ($kh as $khs) {
            $kkm = $khs->kkm;
        }

        if ($request->nilai_a1 + $request->nilai_a2 + $request->nilai_a3 + $request->nilai_a4 >= $kkm) {
            $kriteria = "TUNTAS";
        }
        else{
            $kriteria = "TIDAK TUNTAS";
        }

        DB::table('rekap_kh')->where('r_id',$r_id)->update([
            'nilai_a1' => $request->nilai_a1,
            'nilai_a2' => $request->nilai_a2,
            'nilai_a3' => $request->nilai_a3,
            'nilai_a4' => $request->nilai_a4,
            'total'    => $request->nilai_a1 + $request->nilai_a2 + $request->nilai_a3 + $request->nilai_a4,
            'kriteria' => $kriteria 
        ]);
        return redirect()->route('rekap.guru', $uji_id);
    }
}
