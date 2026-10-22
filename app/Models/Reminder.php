<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'remind_at',
        'completed',
        'notified',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'datetime',
            'remind_at' => 'datetime',
            'completed' => 'boolean',
            'notified' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDue($query)
    {
        return $query->where('completed', false)
            ->where('due_date', '<=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('completed', false)
            ->where('due_date', '>', now())
            ->orderBy('due_date');
    }

    public function scopePending($query)
    {
        return $query->where('completed', false);
    }
}
