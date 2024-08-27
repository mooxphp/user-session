<?php

namespace Moox\UserSession\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserSession extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sessions';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_type',
        'user_id',
        'device_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
        'whitelisted',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'payload' => 'array',
        'last_activity' => 'integer',
        'whitelisted' => 'boolean',
    ];

    /**
     * Get the owning user model, if it exists.
     */
    public function user(): MorphTo
    {
        if (class_exists($this->user_type)) {
            return $this->morphTo();
        }

        return $this->morphTo(null, null, null, null)->withDefault(function ($instance) {
            $instance->id = $this->user_id;
            $instance->name = 'Unknown User';
        });
    }

    /**
     * Get the owning device model.
     */
    public function device(): MorphTo
    {
        return $this->morphTo();
    }
}
