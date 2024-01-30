<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpsCodecoKms extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpscodecokmsxml';
    protected $primaryKey = 'TPSCODECOKMSXML_PK';
    public $timestamps = false;

    public $fillable = [
        'NOJOBORDER',
        'TGL_ENTRY',
        'JAM_ENTRY',
        'REF_NUMBER',
        'UID',
        'NOMOR',
    ];

}