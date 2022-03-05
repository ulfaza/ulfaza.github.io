<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use Notifiable;
    protected $table = 'm_siswa';
    public $timestamps = false;
    protected $primaryKey = 's_id';


    public $incrementing = true;    

    protected $fillable = [
        'nama', 'nis', 'nisn',
    ];

    public function kelas()
    {
        return $this->belongsTo(\App\Kelas::class,'k_id');
    }
}
