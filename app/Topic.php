<?php

namespace App;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Topic
 * @package App
 */
class Topic extends Model
{
    use Orderable;

    /**
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return mixed
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->oldestFirst();
    }
}
