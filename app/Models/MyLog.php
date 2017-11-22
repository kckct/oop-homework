<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MyLog
 * @package App\Models
 */
class MyLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'my_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'config',
    ];
}
