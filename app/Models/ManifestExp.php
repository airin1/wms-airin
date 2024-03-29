<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManifestExp extends Model
{
    protected $table = 'tmanifesteks';
    protected $primaryKey = 'TMANIFEST_PK';
    public $timestamps = false;

    public $fillable = [
        'NOTALLY',
        'NO_PACK',
        'TGL_PACK',
        'MARKING',
        'DESCOFGOODS',
        'WEIGHT',
        'MEAS',
        'TCONSIGNEE_FK',
        'TSHIPPER_FK',
        'TNOTIFYPARTY_FK',
        'TJOBORDER_FK',
        'TCONTAINER_FK',
        'UID',
        'UIDRELEASE',
        'TInvoiceLCL_FK',
        'SFOTO',
        'JMLFOTO',
        'NOPOS',
        'NO_BC11',
        'NO_POS_BC11',
        'NOSEGEL',
        'TGL_HBL',
        'KODE_KEMAS',
        'TGL_BC11',
        'QUANTITY',
        'NAMAPACKING',
        'TPACKING_FK',
        'VALIDASI',
        'DG_SURCHARGE',
        'WEIGHT_SURCHARGE',
        'RACKING',
        'PARTOFF',
        'QUANTITY_VAL',
        'NAMAPACKING_VAL',
        'URAIAN_VAL',
        'TOTAL',
        'KETERANGAN',
        'VAL_DATE',
        'VAL_USER',
        'kerani',
        'kerani_by',
        'kerani_date',
        'kerani_time',
        'koordinator',
        'koordinator_by',
        'koordinator_date',
        'koordinator_time',
        'supervisor',
        'supervisor_by',
        'supervisor_date',
        'supervisor_time',
        'check_date',
        'check_time',
        'check_by',
        'stock_audit',
        'tglentry',
        'jamentry',
        'tglmasuk',
        'jammasuk',
        'tglstufing',
        'jamstufing',
        'tglbehandle',
        'jambehandle',
        'tglfiat',
        'jamfiat',
        'tglrelease',
        'jamrelease',
        'BEHANDLE',
        'REF_NUMBER',
        'tglbuangmty',
        'jambuangmty',
        'NOJOBORDER',
        'NOCONTAINER',
        'SIZE',
        'TCONSOLIDATOR_FK',
        'NAMACONSOLIDATOR',
        'TLOKASISANDAR_FK',
        'KD_TPS_ASAL',
        'ETA',
        'ETD',
        'VESSEL',
        'VOY',
        'CALL_SIGN',
        'TPELABUHAN_FK',
        'NAMAPELABUHAN',
        'PEL_MUAT',
        'PEL_BONGKAR',
        'PEL_TRANSIT',
        'KD_TPS_TUJUAN',
        'KODE_DOKUMEN',
        'ID_CONSIGNEE',
        'CONSIGNEE',
        'NPWP_CONSIGNEE',
        'NO_NPE',
        'TGL_NPE',
        'NAMA_IMP',
        'NPWP_IMP',
        'ALAMAT_IMP',
        'NAMAEMKL',
        'TELPEMKL',
        'NOPOL',
        'TGLCETAKWO',
        'JAMCETAKWO',
        'TGLSURATJALAN',
        'JAMSURATJALAN',
        'UIDSURATJALAN',
        'NOPOL_MASUK',
        'NOPOL_MTY',
        'NOPOL_RELEASE',
        'REF_NUMBER_OUT',
        'LOKASI_GUDANG',
        'SHIPPER',
        'NOTIFYPARTY',
        'ID_CONSOLIDATOR',
        'STARTSTUFING',
        'ENDSTUFING',
        'PENAGIHAN',
        'INVOICE',
        'ESEALCODE',
        'TGL_RESPON',
        'JAM_RESPON',
        'SNM',
        'SNA',
        'CNM',
        'CNA',
        'NNM',
        'NNA',
        'HSCODE',
        'ETA_JAM',
        'SMR',
        'DES',
        'NO_KUITANSI',
        'LOKASI_TUJUAN',
        'flag_bc',
        'no_flag_bc',
        'description_flag_bc',
        'alasan_segel',
        'alasan_lepas_segel',
        'status_bc',
        'release_bc',
        'release_bc_date',
        'release_bc_uid',
        'sor_update',
        'perubahan_hbl',
        'alasan_perubahan',
        'bcf_consignee',
        'photo_stripping',
        'photo_release',
        'photo_release_in',
        'photo_release_out',
        'no_pabean',
        'tgl_pabean',
        'description_unflag_bc',
        'no_unflag_bc',
        'photo_lock',
        'photo_unlock',
        'status_behandle',
        'date_ready_behandle',
        'date_check_behandle',
        'date_finish_behandle',
        'desc_check_behandle',
        'desc_finish_behandle',
        'location_id',
        'location_name',
        'final_qty',
        'hasil_tally',
        'packing_tally',
        'telp_ppjk',
        'photo_behandle',
        'location_behandle',
        'keterangan_release',
		'photo_get_in',
		'photo_get_out',
		'UIDMASUK'
    ];

    public function packing()
{
    return $this->belongsTo(Packing::class, 'TPACKING_FK');
}

public function Photo()
{
    return $this->hasMany(Photo::class, 'id', 'TMANIFEST_PK')
        ->where('type', 'manifest');
}
}

