<?php
namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\ChatbotModel;

class Chatbot extends Controller
{
    // Index method to load chatbot UI
    public function index()
    {
        return view('layout'); // Loads the chatbot view (HTML with Bootstrap design)
    }

    public function register()
    {
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');

        $userModel = new UserModel();
        $userModel->save(['name' => $name, 'phone' => $phone]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function getResponse()
    {
        $question = $this->request->getPost('question');
        $chatResponseModel = new ChatbotModel();
        $response = $chatResponseModel->getAnswer($question);

        $answer = $response ? $response['answer'] : 'Sorry, I can’t understand.';
        return $this->response->setJSON(['answer' => $answer]);
    }
}
