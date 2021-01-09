<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $guarded = [];
    protected $fillable = ['title'];

    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image :'profile/RTeeBJKVghIZelN3K52rnrm1MjsgNRbYD33KmgAc.jpeg';
        return '/storage/'. $imagePath;
    }
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);
    }
}
