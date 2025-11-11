<?php

namespace App\Models\GRH;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceReview extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    protected function casts(): array
    {
        return [
            'review_date' => 'date',
            'rating' => 'integer',
        ];
    }
}
