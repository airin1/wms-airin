<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TpsCoariContDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpscoaricontdetailxml';
    protected $primaryKey = 'TPSCOARICONTDETAILXML_PK';
    public $timestamps = false;

    public $fillable = [
        'TPSCOARICONTXML_FK',
        'REF_NUMBER',
        'KD_DOK',
        'KD_TPS',
        'NM_ANGKUT',
        'NO_VOY_FLIGHT',
        'CALL_SIGN',
        'TGL_TIBA',
        'KD_GUDANG',
        'NO_CONT',
        'UK_CONT',
        'NO_SEGEL',
        'JNS_CONT',
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
        'KD_TIMBUN',
        'KD_DOK_INOUT',
        'NO_DOK_INOUT',
        'TGL_DOK_INOUT',
        'WK_INOUT',
        'KD_SAR_ANGKUT_INOUT',
        'NO_POL',
        'FL_CONT_KOSONG',
        'ISO_CODE',
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
        'NOPLP',
        'TGLPLP',
        'FLAG_REVISI',
        'TGL_REVISI',
        'TGL_REVISI_UPDATE',
        'KD_TPS_ASAL',
        'FLAG_UPD',
        'RESPONSE_MAL0',
        'STATUS_TPS_MAL0',
        'TGL_ENTRY',
        'JAM_ENTRY',
    ] ;

}