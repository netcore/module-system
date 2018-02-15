<?php

namespace Modules\System\Entities;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    /**
     * @var string
     */
    protected $table = 'netcore_system__system_logs';

    /**
     * @var array
     */
    protected $fillable = [];
}
