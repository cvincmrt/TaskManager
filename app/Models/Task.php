<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'creator_id',
        'assigned_to_id',
        'title',
        'description',
        'status',
        'priority',
        'deadline',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    //Scope pre ulohy vytvorene uzivatelom
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('creator_id', $userId);
    }

    //Scope pre ulohy priradene uzivatelovi
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to_id', $userId);
    }
}
