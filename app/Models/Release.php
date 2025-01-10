<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Release extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'releases';

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
