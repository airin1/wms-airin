<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpsCodecoKmsDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpscodecokmsdetailxml';
    protected $primaryKey = 'TPSCODECOKMSDETAILXML_PK';
    public $timestamps = false;

    public $fillable = [
        'TPSCODECOKMSXML_FK',
        'REF_NUMBER',
        'NOJOBORDER',
        'NOTALLY',
        'KD_DOK',
        'KD_TPS',
        'NM_ANGKUT',
        'NO_VOY_FLIGHT',
        'CALL_SIGN',
        'TGL_TIBA',
        'KD_GUDANG',
        'NO_BL_AWB',
        'TGL_BL_AWB',
        'NO_MASTER_BL_AWB',
        'TGL_MASTER_BL_AWB',
        'ID_CONSIGNEE',
        'CONSIGNEE',
        'BRUTO',
        'NO_BC11',
        'TGL_BC11',
        'NO_POS_BC11',
        'CONT_ASAL',
        'SERI_KEMAS',
        'KD_KEMAS',
        'JML_KEMAS',
        'KD_TIMBUN',
        'KD_DOK_INOUT',
        'NO_DOK_INOUT',
        'TGL_DOK_INOUT',
        'WK_INOUT',
        'KD_SAR_ANGKUT_INOUT',
        'NO_POL',
        'PEL_MUAT',
        'PEL_TRANSIT',
        'PEL_BONGKAR',
        'GUDANG_TUJUAN',
        'UID',
        'NOURUT',
        'RESPONSE',
        'STATUS_TPS',
        'KODE_KANTOR',
        'NO_DAFTAR_PABEAN',
        'TGL_DAFTAR_PABEAN',
        'NO_SEGEL_BC',
        'TGL_SEGEL_BC',
        'NO_IJIN_TPS',
        'TGL_IJIN_TPS',
        'RESPONSE_IPC',
        'STATUS_TPS_IPC',
        'KD_TPS_ASAL',
        'TGL_ENTRY',
        'JAM_ENTRY',
    ];

}