<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Console extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consoles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'company_id',
        'serial_number',
        'region_id',
        'version',
        'box',
        'papers',
        'special_edition',
        'sealed',
        'deleted',
        'price',
        'delivery',
        'is_highlighted'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCompany()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function getRegion()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    public function getPhoto()
    {
        $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
        $photoName = strtolower($this->id . '_' . str_replace($punctuations, "", $this->title) . '.jpg');
        $photoName = str_replace(" ", "_", $photoName);
        if(file_exists('img/consoles/' . $photoName)){
            return asset('img/consoles/' . $photoName);
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

    public function getGalleryPhotoName(){
        $id = $this->id;
        $title = $this->title;
        $titleClear = str_replace(" ", "_", $title);
        $titleClear = str_replace("/", "", $titleClear);
        $imgTitle = $id.'_'.strtolower($titleClear);

        return $imgTitle;
    }
}
