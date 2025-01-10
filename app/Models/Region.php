<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Region extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'regions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'deleted'
    ];
}
