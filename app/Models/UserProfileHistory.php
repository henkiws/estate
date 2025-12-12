<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_profile_id',
        'user_id',
        'admin_id',
        'action',
        'previous_status',
        'new_status',
        'reason',
        'admin_notes',
        'changes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    /**
     * Get the user profile this history belongs to
     */
    public function profile()
    {
        return $this->belongsTo(UserProfile::class, 'user_profile_id');
    }

    /**
     * Get the user whose profile this is
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin who performed the action
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get formatted action text
     */
    public function getActionTextAttribute()
    {
        $actions = [
            'submitted' => 'Submitted for Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'updated' => 'Updated',
        ];

        return $actions[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Get status color class
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'approved' => 'green',
            'rejected' => 'red',
            'pending' => 'yellow',
            'draft' => 'gray',
        ];

        return $colors[$this->new_status] ?? 'gray';
    }

    /**
     * Scope to get recent history
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Scope to filter by action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by admin
     */
    public function scopeByAdmin($query, $adminId)
    {
        return $query->where('admin_id', $adminId);
    }
}