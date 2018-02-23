<?php

namespace Modules\System\Models;

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
    protected $guarded = [];


    /**
     * -------------------------------
     * Relationships
     * -------------------------------
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(app(config('netcore.module-admin.user.model')));
    }

    /**
     * -------------------------------
     * Accessors
     * -------------------------------
     */

    /**
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}
