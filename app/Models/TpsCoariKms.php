<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpsCoariKms extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpscoarikmsxml';
    protected $primaryKey = 'TPSCOARIKMSXML_PK';
    public $timestamps = false;

    public $fillable = [
        'TGL_ENTRY',
        'JAM_ENTRY',
        'REF_NUMBER',
        'UID',
        'NOMOR',
    ];

}