<?php

use App\Core\Controller;

class Users extends Controller
{
    public function index()
    {
        $userModel = $this->model("User");

        $user = $userModel->readAll();

        if (!$user) {
            http_response_code(404);
            echo json_encode(["erro" => "Registro não encontrado."]);

            exit;
        }

        echo json_encode($user, JSON_UNESCAPED_UNICODE);
    }

    public function store()
    {
        $newUser = $this->getRequestBody();

        $userModel = $this->model("User");

        $userModel->full_name = $newUser->full_name;
        $userModel->birth_date = $newUser->birth_date;
        $userModel->email = $newUser->email;
        $userModel->profession = $newUser->profession;
        $userModel->tel = $newUser->tel;
        $userModel->cel = $newUser->cel;
        $userModel->cel_has_whatsapp = $newUser->cel_has_whatsapp;
        $userModel->notify_email = $newUser->notify_email;
        $userModel->notify_sms = $newUser->notify_sms;

        if (empty($userModel->full_name) || 
            empty($userModel->birth_date) || 
            empty($userModel->email) || 
            empty($userModel->cel)) {

            http_response_code(500);
            echo json_encode(["erro" => "Campos obrigatórios não preenchidos."]);
        } else if ($userModel) {
            $userModel = $userModel->create();

            http_response_code(201);
            echo json_encode(["success" => "Registro cadastrado com sucesso."]);
        }
    }

    public function update($id)
    {
        $newUser = $this->getRequestBody();

        $userModel = $this->model("User");

        $userModel = $userModel->readById($id);

        $userModel->full_name = $newUser->full_name;
        $userModel->birth_date = $newUser->birth_date;
        $userModel->email = $newUser->email;
        $userModel->profession = $newUser->profession;
        $userModel->tel = $newUser->tel;
        $userModel->cel = $newUser->cel;
        $userModel->cel_has_whatsapp = $newUser->cel_has_whatsapp;
        $userModel->notify_email = $newUser->notify_email;
        $userModel->notify_sms = $newUser->notify_sms;

        if (empty($userModel->full_name) || 
            empty($userModel->birth_date) || 
            empty($userModel->email) || 
            empty($userModel->cel)) {

            http_response_code(500);
            echo json_encode(["erro" => "Campos obrigatórios não preenchidos."]);
        } else {
            $userModel->update();

            http_response_code(201);
            echo json_encode(["success" => "Registro atualizado com sucesso."]);
        }
    }

    public function delete($id)
    {
        $userModel = $this->model("User");

        $userModel = $userModel->readById($id);

        if (!$userModel) {
            http_response_code(404);
            echo json_encode(["erro" => "Registro não encontrado."]);
            exit;
        } else {
            http_response_code(200);
            echo json_encode(["success" => "Registro excluído com sucesso."]);
        }

        $userModel->delete();
    }
}
