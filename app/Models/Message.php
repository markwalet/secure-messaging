<?php

namespace App\Models;

use Database\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use MarkWalet\LaravelHashedRoute\Concerns\HasHashedRouteKey;

/**
 * @property-read int    $id
 * @property int         $colleague_id
 * @property Colleague   $colleague
 * @property int         $user_id
 * @property User        $user
 * @property string      $password
 * @property string      $message
 * @property Carbon      $available_until
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @method static MessageFactory factory(...$parameters)
 */
class Message extends Model
{
    use HasFactory;
    use Prunable;
    use HasHashedRouteKey;

    /**
     * The number of hours the message will be available for the receiving colleague.
     */
    public const KEEPALIVE = 24;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'available_until' => 'date',
        'colleague_id'    => 'int',
        'user_id'         => 'int',
    ];

    /**
     * Get the prunable model query.
     *
     * @return Builder
     */
    public function prunable(): Builder
    {
        return static::query()->where('available_until', '<', now());
    }

    /**
     * Get a query builder instance for the `colleague` relation.
     *
     * @return BelongsTo
     */
    public function colleague(): BelongsTo
    {
        return $this->belongsTo(Colleague::class);
    }

    /**
     * Get a query builder instance for the `user` relation.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
