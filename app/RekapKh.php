<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class RekapKh extends Model
{
    use Notifiable;

	protected $table = 'rekap_kh';
	public $timestamps = false;
    protected $primarykey = 'r_id';

    protected $fillable = [
        'nilai_a1', 'nilai_a2', 'nilai_a3', 'nilai_a4', 'kriteria', 
    ];

    public function uji_kh()
    {
        return $this->belongsTo(\App\UjiKh::class,'uji_id');
    }
}