<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['voter_id', 'nominee_id', 'category_id'];

    public function voter()
    {
        return $this->belongsTo(Teacher::class, 'voter_id');
    }

    public function nominee()
    {
        return $this->belongsTo(Teacher::class, 'nominee_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
