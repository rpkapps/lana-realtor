<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\MlsPullDate
 *
 * @property int $id
 * @property string|null $connector_class
 * @property string|null $pull_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MlsPullDate whereConnectorClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MlsPullDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MlsPullDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MlsPullDate wherePullDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MlsPullDate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MlsPullDate extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
