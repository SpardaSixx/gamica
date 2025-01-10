<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Rank extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ranks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'deleted'
    ];
}
