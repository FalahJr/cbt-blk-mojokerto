<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $assignment_id
 * @property integer $user_id
 * @property string $file
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property Assignment $assignment
 * @property User $user
 */
class AssignmentSubmission extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'assignment_submission';

    /**
     * @var array
     */
    protected $fillable = ['assignment_id', 'user_id', 'file', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignment()
    {
        return $this->belongsTo('App\Models\Assignment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
