<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $quizzes_id
 * @property string $question
 * @property string $option_a
 * @property string $option_b
 * @property string $option_c
 * @property string $option_d
 * @property string $option_e
 * @property string $correct_answer
 * @property string $created_at
 * @property string $updated_at
 * @property Quiz $quiz
 * @property UserAnswer[] $userAnswers
 */
class Questions extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['quizzes_id', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'option_e', 'correct_answer', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo('App\Models\Quiz', 'quizzes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAnswers()
    {
        return $this->hasMany('App\Models\UserAnswer');
    }
}
