<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $materi_id
 * @property integer $periode_id
 * @property string $tanggal_mulai
 * @property string $title
 * @property integer $timer
 * @property string $deskripsi
 * @property string $created_at
 * @property string $updated_at
 * @property Question[] $questions
 * @property QuizAttempt[] $quizAttempts
 * @property Materi $materi
 * @property Periode $periode
 * @property StudentQuizAttempt[] $studentQuizAttempts
 */
class Quizzes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['materi_id', 'periode_id', 'tanggal_mulai', 'title', 'timer', 'kode', 'deskripsi', 'created_at', 'updated_at'];

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
        return $this->hasMany('App\Models\QuizAttempt', 'quizzes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function periode()
    {
        return $this->belongsTo('App\Models\Periode');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentQuizAttempts()
    {
        return $this->hasMany('App\Models\StudentQuizAttempt', 'quizzes_id');
    }
}
