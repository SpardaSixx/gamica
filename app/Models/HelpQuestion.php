<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
//use App\Models\HelpQuestions2Answers;
 
class HelpQuestion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'help_questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'anonymous',
        'user_id'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getAnswers()
    {
        return $this->hasMany(HelpQuestions2Answers::class, 'question_id', 'id');
    }
}
