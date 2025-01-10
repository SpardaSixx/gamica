<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Platform extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'platforms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'title_short',
        'company_id',
        'release_year',
        'description',
        'amount',
        'deleted'
    ];

    public function getCompany()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function getPhoto()
    {
        $photoName = strtolower($this->id . '_' . $this->title . '.jpg');
        $photoName = str_replace(" ", "_", $photoName);
        if(file_exists('img/platforms/' . $photoName)){
            return asset('img/platforms/' . $photoName);
        } else{
            return ('/img/default.png');
        }
    }

    public function getPhotoName()
    {
        $photoName = strtolower($this->id . '_' . $this->title . '.jpg');
        $photoName = str_replace(" ", "_", $photoName);
        return $photoName;
    }

    public function getGames()
    {
        return Game::where('platform_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getRecommendations()
    {
        return Game::where('platform_id', $this->id)->where('deleted', 0)->inRandomOrder()->limit(10)->get();
    }

    public function getSales()
    {
        return Sale::where('platform_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getWanteds()
    {
        return Wanted::where('platform_id', $this->id)->where('deleted', 0)/* ->where('is_found', 0) */->orderBy('id', 'desc')->get();
    }
}
