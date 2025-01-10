<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Gyros extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gyros';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'counter'
    ];
}
