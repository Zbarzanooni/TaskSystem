<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    const STATUS = [
        'open'     => 'open',
        'closed'   => 'closed',
        'archived' => 'archived'
    ];
    const PRIORITY = [
        'low'    => 'low',
        'medium' => 'medium',
        'high'   => 'high'
    ];
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'comment',
        'is_resolved',
        'assigned_to',
        'assigned_by'
    ];

    public function assignedTo(){
        return $this->belongsTo(User::class,'assigned_to');
    }
    public function assignedBy(){
        return $this->belongsTo(User::class,'assigned_by');
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
}
