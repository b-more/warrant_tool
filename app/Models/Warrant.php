<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warrant extends Model
{
     use HasFactory;

    protected $fillable = [
        'warrant_number',
        'officer_name',
        'station',
        'phone_numbers',
        'suspect_name',
        'description',
        'period_from',
        'period_to',
        'status',
        'cdr_file_path',
        'kyc_file_path',
        'user_id',
        'case_id',
        'department_id'
    ];

    protected $casts = [
        'phone_numbers' => 'array',
        'period_from' => 'date',
        'period_to' => 'date',
    ];

    // Relationships using unsignedBigInteger
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for formatted phone numbers (handles nullable)
    protected function phoneNumbersList(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->phone_numbers ? implode(', ', $this->phone_numbers) : 'No phone numbers'
        );
    }

    // Check if warrant has files uploaded
    public function hasFiles(): bool
    {
        return !empty($this->cdr_file_path) || !empty($this->kyc_file_path);
    }

    // Get status badge color for UI (handles nullable)
    public function getStatusColor(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'completed' => 'green',
            default => 'gray'
        };
    }

    // Get formatted status (handles nullable)
    public function getFormattedStatus(): string
    {
        return $this->status ? ucfirst($this->status) : 'Unknown';
    }

    // Scope for filtering by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for filtering by user
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
