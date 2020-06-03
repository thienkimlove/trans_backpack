<?php

namespace App\Models;

use App\Helpers;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'machines';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'bank_id',
        'code',
        'max_amount_per_date',
        'max_amount_per_trans',
        'fee_percent_per_trans',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function availableBanks()
    {
        return $this->belongsToMany(Bank::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setMaxAmountPerDateAttribute($value)
    {
        $this->attributes['max_amount_per_date'] = Helpers::setRequestAmount($value);
    }

    public function setMaxAmountPerTransAttribute($value)
    {
        $this->attributes['max_amount_per_trans'] = Helpers::setRequestAmount($value);
    }
}
