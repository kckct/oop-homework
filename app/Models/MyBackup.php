<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyBackup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'my_backup';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'file_date_time', 'size', 'target',
    ];
}
