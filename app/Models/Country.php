<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_id',
        'country_name',
        'deleted'
    ];
}