<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $quizzes_id
 * @property integer $score
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Quiz $quiz
 * @property UserAnswer[] $userAnswers
 */
class QuizAttempts extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'quizzes_id', 'score', 'created_at', 'updated_at'];

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
    public function quiz()
    {
        return $this->belongsTo('App\Models\Quizzes', 'quizzes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAnswers()
    {
        return $this->hasMany('App\Models\UserAnswers');
    }
}
