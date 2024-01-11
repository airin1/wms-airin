<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContainerExp extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tcontainereks';
    protected $primaryKey = 'TCONTAINER_PK';
    public $timestamps = false;
    public $fillable = [
        'NOCONTAINER',
        'SIZE',
        'TEUS',
        'NO_SEAL',
        'TJOBORDER_FK',
        'NoJob',
        'NOSPK',
        'NO_BC11',
        'TGL_BC11',
        'NO_PLP',
        'TGL_PLP',
        'TCONSOLIDATOR_FK',
        'NAMACONSOLIDATOR',
        'TLOKASISANDAR_FK',
        'ETA',
        'ETD',
        'VESSEL',
        'VOY',
        'TPELABUHAN_FK',
        'NAMAPELABUHAN',
        'PEL_MUAT',
        'PEL_BONGKAR',
        'PEL_TRANSIT',
        'NOBOOKING',
        'TGL_BOOKING',
        'KD_TPS_ASAL',
        'KD_TPS_TUJUAN',
        'LOKASI_GUDANG',
        'CALL_SIGN',
        'UIDMASUK',
        'NOPOL_MASUK',
        'NOPOL_KELUAR',
        'TGLMASUK',
        'JAMMASUK',
        'WEIGHT',
        'MEAS',
        'status_bc',
        'KD_DOKUMEN',
        'NO_PKBE',
        'TGL_PKBE',
        'TGLKELUAR',
        'JAMKELUAR',
        'release_bc_uid',
        'release_bc_date',
        'release_bc',
        'TYPE',
        'CTR_STATUS',
        'TGLENTRY',
        'JAMENTRY',
        'UID',
        'photo_get_in',
        'photo_get_out',
        'photo_stripping',
		'TGLRELEASE', 
        'JAMRELEASE',
        'UIDKELUAR',
        'TGLFIAT',
        'JAMFIAT',
        'TGLSURATJALAN', 
        'JAMSURATJALAN' ,
		'photo_release_in',
		'photo_release_out',
        'REF_NUMBER_IN'
    ];


    public function job()
    {
        return $this->belongsTo(JoborderExp::class, 'TJOBORDER_FK', 'TJOBORDER_PK');
    }

    public function barang()
    {
        return $this->hasMany(ManifestExp::class, 'TCONTAINER_FK', 'TCONTAINER_PK');
    }

        public function Photo()
    {
        return $this->hasMany(Photo::class, 'id', 'TCONTAINER_PK')
            ->where('type', 'container');
    }


}

//class Containercy extends Model
//{
//    /**
//     * The database table used by the model.
//     *
//     * @var string
//     */
//    protected $table = 'tcontainercy';
//    protected $primaryKey = 'TCONTAINER_PK';
//    public $timestamps = false;
//
//}
