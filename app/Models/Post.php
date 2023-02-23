<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class)
            ->withPivot('sent_at')
            ->wherePivotNull('sent_at');
    }
}
