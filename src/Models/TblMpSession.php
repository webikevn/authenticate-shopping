<?php

namespace Webikevn\AuthenticateShopping\Models;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TblMpSession.
 *
 * tbl_mp_session model.
 * @property string $session_id
 * @property string $session_kaiin_id
 * @property string $session_key
 * @property array $content
 * @property CarbonImmutable $expiry_date
 * @property CarbonImmutable $created_date
 * @property CarbonImmutable $updated_date
 * @mixin \Eloquent
 */
class TblMpSession extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'tbl_mp_session';

    /**
     * The primary key for the model.
     * @var string
     */
    protected $primaryKey = 'session_id';

    /**
     * The connection name for the model.
     * @var string
     */
    protected $connection = 'wgs';

    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'session_id',
        'session_key',
        'session_kaiin_id',
        'expiry_date',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'content' => 'array'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_date' => 'datetime:Y-m-d H:i:s',
        'updated_date' => 'datetime:Y-m-d H:i:s',
        'expiry_date' => 'datetime:Y-m-d H:i:s',
    ];
}
