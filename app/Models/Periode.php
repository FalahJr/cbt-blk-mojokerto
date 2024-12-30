<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nama
 * @property string $created_at
 * @property string $updated_at
 * @property Quiz[] $quizzes
 */
class Periode extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'periode';

    /**
     * @var array
     */
    protected $fillable = ['nama', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizzes()
    {
        return $this->hasMany('App\Models\Quizzes');
    }
}
