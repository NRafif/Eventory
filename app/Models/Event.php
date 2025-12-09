<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'title',
        'slug',
        'description',
        'location',
        'event_date',
        'start_time',
        'end_time',
        'quota',
        'registered_count',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'quota' => 'integer',
        'registered_count' => 'integer',
    ];

    // Relationships
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'registrations')
            ->withPivot('status', 'registered_at')
            ->withTimestamps();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now())
            ->where('status', 'published')
            ->orderBy('event_date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now())
            ->orderBy('event_date', 'desc');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helper Methods
    public function isFull()
    {
        return $this->registered_count >= $this->quota;
    }

    public function availableSlots()
    {
        return max(0, $this->quota - $this->registered_count);
    }

    public function isUpcoming()
    {
        return $this->event_date >= now() && $this->status === 'published';
    }

    public function isPast()
    {
        return $this->event_date < now();
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'published' => 'bg-green-100 text-green-800',
            'draft' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getFormattedDate()
    {
        return $this->event_date->format('d M Y');
    }

    public function getFormattedTime()
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }

    public function isRegistered($userId)
    {
        return $this->registrations()->where('user_id', $userId)->exists();
    }

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . Str::random(6);
            }
        });
    }
}
