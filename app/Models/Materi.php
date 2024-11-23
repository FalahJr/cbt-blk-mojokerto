<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $judul
 * @property string $deskripsi
 * @property string $file
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Materi extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'materi';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'judul', 'deskripsi', 'file', 'gambar', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
