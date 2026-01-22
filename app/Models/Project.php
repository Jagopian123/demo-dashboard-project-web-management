<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'name',
        'code',
        'status',
        'priority',
        'description',
        'price',
        'progress',
        'start_date',
        'deadline',
        'completed_date',
        'project_url',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'progress' => 'integer',
        'start_date' => 'date',
        'deadline' => 'date',
        'completed_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }
}
