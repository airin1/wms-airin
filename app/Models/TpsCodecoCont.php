<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpsCodecoCont extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpscodecocontxml';
    protected $primaryKey = 'TPSCODECOCONTXML_PK';
    public $timestamps = false;

    public $fillable =[
        'NOJOBORDER',
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