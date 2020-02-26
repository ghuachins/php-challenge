<?php


namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $table = 'exchange_rate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rate',
    ];

    public function setKeysForSaveQuery(Builder $query)
    {
        $query->where('currencyIdFrom', '=', $this->currencyIdFrom);
        $query->where('currencyIdTo', '=', $this->currencyIdTo);

        return $query;
    }

}
