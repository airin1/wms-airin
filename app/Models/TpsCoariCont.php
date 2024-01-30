<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpsCoariCont extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpscoaricontxml';
    protected $primaryKey = 'TPSCOARICONTXML_PK';
    public $timestamps = false;

    public $fillable = [
        'REF_NUMBER',
        'TGL_ENTRY',
        'JAM_ENTRY',
        'UID',
        'NOMOR',
        'STATUS_REF',
        'REF_NUMBER_REVISI',
        'FLAG_REVISI',
        'TGL_REVISI',
    ];

}