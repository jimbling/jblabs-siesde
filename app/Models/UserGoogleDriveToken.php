<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserGoogleDriveToken extends Model
{
    protected $fillable = [
        'user_id',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'connected_at',
        'name',
        'email',
        'picture',
    ];

    protected $dates = [
        'token_expires_at',
        'connected_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'connected_at' => 'datetime',
        'token_expires_at' => 'datetime',
    ];

    public function getTokenArray()
    {
        $expiresIn = $this->token_expires_at->diffInSeconds(now());
        if ($expiresIn < 0) $expiresIn = 0;

        return [
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'expires_in' => $expiresIn,
            'created' => now()->subSeconds($expiresIn)->timestamp,
        ];
    }
}
