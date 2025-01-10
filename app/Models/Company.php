<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'country_id',
        'deleted'
    ];

    public function getCountry()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function getConsoles()
    {
        return Console::where('company_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getAccessories()
    {
        return Accessory::where('company_id', $this->id)->where('deleted', 0)->where('is_sold', 0)->orderBy('id', 'desc')->get();
    }
}
