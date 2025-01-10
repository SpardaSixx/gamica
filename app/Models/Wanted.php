<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Wanted extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wanteds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'price',
        'delivery',
        'preferred_area',
        'is_found',
        'platform_id',
        'serial_number',
        'region_id',
        'release_id',
        'language_id',
        'manual',
        'special_edition',
        'sealed',
        'deleted'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getPlatform()
    {
        return $this->hasOne(Platform::class, 'id', 'platform_id');
    }

    public function getRegion()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    public function getRelease()
    {
        return $this->hasOne(Release::class, 'id', 'release_id');
    }

    public function getCoverLanguage()
    {
        return $this->hasOne(Language::class, 'id', 'cover_language_id');
    }

    public function getGameLanguage()
    {
        return $this->hasOne(Language::class, 'id', 'game_language_id');
    }

    public function getPhoto()
    {
        $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
        $photoName = strtolower($this->id . '_' . str_replace($punctuations, "", $this->title) . '.jpg');
        $photoName = str_replace(" ", "_", $photoName);
        if(file_exists('img/wanteds/' . $photoName)){
            return asset('img/wanteds/' . $photoName);
        } else{
            return ('/img/default.png');
        }
    }

    public function getPhotoName()
    {
        $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
        $photoName = strtolower($this->id . '_' . str_replace($punctuations, "", $this->title) . '.jpg');
        $photoName = str_replace(" ", "_", $photoName);
        return $photoName;
    }

    public function getPrice(){
        return number_format($this->price, 0, ",", " ");
    }
}
