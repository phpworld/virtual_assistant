<?php namespace App\Models;

use CodeIgniter\Model;

class ChatbotModel extends Model
{
    protected $table = 'chatbot_responses';
    protected $primaryKey = 'id';

    protected $allowedFields = ['question', 'answer'];

    public function getAnswer($question)
    {
        return $this->where('question', $question)->first();
    }
}
