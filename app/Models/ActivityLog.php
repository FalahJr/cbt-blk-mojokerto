<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $materi_id
 * @property string $start_time
 * @property string $end_time
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Materi $materi
 */
class ActivityLog extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'activity_log';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'materi_id', 'start_time', 'end_time', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materi()
    {
        return $this->belongsTo('App\Models\Materi');
    }
}
