<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'favorites';
    protected $fillable = [
        'title', 'image', 'status','publisher_id'
    ];

    public function publisher() {
        return $this->belongsTo(Publisher::class);
    }
}
