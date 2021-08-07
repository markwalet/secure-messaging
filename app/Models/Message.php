<?php

namespace App\Models;

use Database\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int    $id
 * @property int         $colleague_id
 * @property Colleague   $colleague
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
    ];

    /**
     * Get a query builder instance for the `colleague` relation.
     *
     * @return BelongsTo
     */
    public function colleague(): BelongsTo
    {
        return $this->belongsTo(Colleague::class);
    }
}
