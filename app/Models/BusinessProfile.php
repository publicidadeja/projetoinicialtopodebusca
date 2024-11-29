<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'business_name',
        'address',
        'phone',
        'website',
        'business_hours',
        'google_business_id',
        'google_account_id',
    ];

    protected $casts = [
        'business_hours' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(BusinessPost::class);
    }

    public function reviews()
    {
        return $this->hasMany(BusinessReview::class);
    }
}