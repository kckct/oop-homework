<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MyBackup
 * @package App\Models
 */
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
        'name', 'fileDateTime', 'size', 'handlers', 'target',
    ];
}
