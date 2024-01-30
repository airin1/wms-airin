<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoborderExp extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tjobordereks';
    protected $primaryKey = 'TJOBORDER_PK';
    public $timestamps = false;

    public $fillable = [
        'TJOBORDER_PK',
        'TGLENTRY',
        'NOPLP',
        'PARTY',
        'NOBOOKING',
        'TGL_BOOKING',
        'VESSEL',
        'CALLSIGN',
        'VOY',
        'ETA',
        'ETD',
        'GROSSWEIGHT',
        'JUMLAHHBL',
        'MEASUREMENT',
        'KETERANGAN',
        'JABATAN',
        'ALAMAT',
        'JENISKEGIATAN',
        'TCONSOLIDATOR_FK',
        'TNEGARA_FK',
        'TPELABUHAN_FK',
        'HISTORY',
        'NOJOBORDER',
        'NOSPK',
        'TLOKASISANDAR_FK',
        'TGLMASUKAPW',
        'TGLBUANGMTY',
        'UID',
        'TInvoiceOBStripping_FK',
        'NO_BC11',
        'TGL_BC11',
        'STATUS_PLP',
        'GAB_NO_BC11',
        'ISO_CODE',
        'PEL_MUAT',
        'PEL_TRANSIT',
        'PEL_BONGKAR',
        'GUDANG_TUJUAN',
        'TSHIPPINGLINE_FK',
        'SHIPPINGLINE',
        'URAIAN_OPR',
        'URAIAN_FIN',
        'eTiketDate',
        'eTiketTime',
        'eTiket_By',
        'ePLPDate',
        'ePLPTime',
        'ePLP_by',
        'ePLPFinalDate',
        'ePLPFinalTime',
        'ePLPFinal_by',
        'cprid',
        'tgl_buk',
        'tgl_truck',
        'KODE_GUDANG',
        'truck_by',
        'NAMACONSOLIDATOR',
        'NAMANEGARA',
        'NAMAPELABUHAN',
        'NAMALOKASISANDAR',
        'TNO_BC11',
        'TTGL_BC11',
        'TNO_PLP',
        'TTGL_PLP',
        'JAMENTRY',
        'C_DATETIME',
        'LASTUPDATE',
        'LOKASI_GUDANG',
        'KD_TPS_ASAL',
        'ID_CONSOLIDATOR',
    ];

}

