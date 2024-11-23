<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $materi_id
 * @property string $judul
 * @property string $deskripsi
 * @property string $created_at
 * @property string $updated_at
 * @property Question[] $questions
 * @property QuizAttempt[] $quizAttempts
 * @property Materi $materi
 * @property StudentQuizAttempt[] $studentQuizAttempts
 */
class Quizzes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['materi_id', 'title', 'deskripsi', 'timer', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Models\Questions', 'quizzes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizAttempts()
    {
        return $this->hasMany('App\Models\QuizAttempts', 'quizzes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materi()
    {
        return $this->belongsTo('App\Models\Materi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentQuizAttempts()
    {
        return $this->hasMany('App\Models\StudentQuizAttempt', 'quizzes_id');
    }
}
