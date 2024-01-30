<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'barcode_autogate';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ref_type',
        'ref_id',
        'ref_action',
        'ref_number',
        'barcode',
        'status',
        'expired',
        'UID',
        'time_in',
        'time_out'

    ];

    public function manifest()
    {
        return $this->belongsTo(ManifestExp::class, 'ref_id', 'TMANIFEST_PK');
    }

    public function container()
    {
        return $this->belongsTo(ContainerExp::class, 'ref_id', 'TCONTAINER_PK');
    }

    public function jobContainer()
    {
        return $this->belongsTo(JoborderExp::class, 'TJOBORDER_PK')
            ->leftJoin('tcontainereks', 'tjobordereks.TJOBORDER_PK', '=', 'tcontainereks.TJOBORDER_FK')
            ->select('tjobordereks.*', 'tjobordereks.NAMACONSOLIDATOR','tjobordereks.NOBOOKING', 'tjobordereks.TGL_BOOKING');
    }
    
}
