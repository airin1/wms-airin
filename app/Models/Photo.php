<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'photo_export';
    protected $primaryKey = 'photo_id';
    public $timestamps = false;

    public $fillable = [
        'type',
        'activity',
        'id',
        'photo',
        'UID',
    ];
    

}
