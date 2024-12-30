<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $quiz_attempts_id
 * @property integer $nilai_wawancara
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property QuizAttempt $quizAttempt
 */
class Kelulusan extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'kelulusan';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'quiz_attempts_id', 'nilai_wawancara', 'status', 'created_at', 'updated_at'];

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
    public function quizAttempt()
    {
        return $this->belongsTo('App\Models\QuizAttempts', 'quiz_attempts_id');
    }
}
