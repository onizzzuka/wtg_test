<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class message extends Model {

    use HasFactory;

    protected $fillable = [
        'message',
        'from',
        'to',
    ];

    public function from(): BelongsTo {
        return $this->belongsTo(User::class, 'from');
    }

    public function to(): BelongsTo {
        return $this->belongsTo(User::class, 'to');
    }
}
