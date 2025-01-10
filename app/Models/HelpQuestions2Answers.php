<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class HelpQuestions2Answers extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'help_questions2answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'answer_id'
    ];

    public function getQuestion()
    {
        return $this->hasOne(HelpQuestion::class, 'id', 'question_id');
    }

    public function getAnswer()
    {
        return $this->hasOne(HelpAnswer::class, 'id', 'answer_id');
    }
}
