<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EVENEMENTSPORTIF
 *
 * @property int $IDSERVICE
 * @property int $IDSPORT
 * @property string $LIEUEVENT
 * @property Carbon $DATEEVENT
 *
 * @property SERVICE $s_e_r_v_i_c_e
 * @property SPORT $s_p_o_r_t
 *
 * @package App\Models
 */
class EVENEMENTSPORTIF extends Model
{
	protected $table = 'EVENEMENT_SPORTIF';
	protected $primaryKey = 'IDSERVICE';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'IDSERVICE' => 'int',
		'IDSPORT' => 'int',
		'DATEEVENT' => 'datetime'
	];

	protected $fillable = [
		'IDSPORT',
		'LIEUEVENT',
		'DATEEVENT'
	];

	public function s_e_r_v_i_c_e()
	{
		return $this->belongsTo(Service::class, 'IDSERVICE');
	}

	public function s_p_o_r_t()
	{
		return $this->belongsTo(Sport::class, 'IDSPORT');
	}

    public function nbPersonneReservation()
    {
        return $this->hasMany(Reservation::class,'IDSERVICE')->count();
    }
}
