<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read int    $id
 * @property string      $name
 * @property string      $email
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Colleague extends Model
{
    use HasFactory;
}
