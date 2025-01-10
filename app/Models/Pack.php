<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Pack extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'packs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
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

    public function getPhoto()
    {
        $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
        $photoName = strtolower($this->id . '_' . str_replace($punctuations, "", $this->title) . '.jpg');
        $photoName = str_replace(" ", "_", $photoName);
        if(file_exists('img/packs/' . $photoName)){
            return asset('img/packs/' . $photoName);
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
