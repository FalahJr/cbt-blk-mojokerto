<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $materi_id
 * @property string $judul
 * @property string $deskripsi
 * @property string $file
 * @property string $start_date
 * @property string $end_date
 * @property string $gambar
 * @property string $created_at
 * @property string $updated_at
 * @property Materi $materi
 */
class Assignment extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'assignment';

    /**
     * @var array
     */
    protected $fillable = ['materi_id', 'judul', 'deskripsi', 'file', 'start_date', 'end_date', 'gambar', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materi()
    {
        return $this->belongsTo('App\Models\Materi');
    }
}
