<?php

namespace App\Api\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Profile contains health data that used for calculate calories limit.
 *
 * @property string $user_id
 * @property int $age full years
 * @property int $weight in kg
 * @property int $height in cm
 * @property int $gender true male, false female
 * @property float $modifier calories total modifier for surplus or deficit calories
 * @property float $activity activity factor that increase calories limit
 * @property int $calories daily calories limit
 * @property string|Carbon $created_at
 * @property string|Carbon $updated_at
 */
class Profile extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->timestamps = true;
        $this->incrementing = false;
        $this->table = 'profiles';
        $this->fillable = [
            'user_id',
            'age',
            'weight',
            'height',
            'gender',
            'modifier',
            'activity',
            'calories'
        ];
        $this->casts = [
            'gender' => 'bool',
            'modifier' => 'float',
            'activity' => 'float'
        ];
        $this->primaryKey = 'user_id';

        parent::__construct($attributes);
    }
}