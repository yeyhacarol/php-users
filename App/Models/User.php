<?php

use App\Core\Model;

class User
{
    public $id;
    public $full_name;
    public $birth_date;
    public $email;
    public $profession;
    public $tel;
    public $cel;
    public $created_at;
    public $updated_at;
    public $cel_has_whatsapp;
    public $notify_email;
    public $notify_sms;

    public function create()
    {
        $today = date('Y-m-d H:i:s');

        $sql = '
        insert into users 
            (full_name, 
            birth_date, 
            email, 
            profession, 
            tel, 
            cel,
            cel_has_whatsapp,
            notify_email,
            notify_sms,
            created_at, 
            updated_at) 
        values 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = Model::getConnection()->prepare($sql);

        $this->created_at = $today;
        $this->updated_at = $today;

        $stmt->bindValue(1, $this->full_name);
        $stmt->bindValue(2, $this->birth_date);
        $stmt->bindValue(3, $this->email);
        $stmt->bindValue(4, $this->profession);
        $stmt->bindValue(5, $this->tel);
        $stmt->bindValue(6, $this->cel);
        $stmt->bindValue(7, intval($this->cel_has_whatsapp));
        $stmt->bindValue(8, intval($this->notify_email));
        $stmt->bindValue(9, intval($this->notify_sms));
        $stmt->bindValue(10, $this->created_at);
        $stmt->bindValue(11, $this->updated_at);

        if ($stmt->execute()) {
            $this->id = Model::getConnection();

            return $this;
        } else {
            print_r($stmt->errorInfo());

            return null;
        }
    }

    public function readAll()
    {
        $sql = 'select * from users where deleted = 0 order by id desc';

        $stmt = Model::getConnection()->prepare($sql);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $response;
        } else {
            return null;
        }
    }

    public function readById($id)
    {
        $sql = 'select * from users where id = ?';

        $stmt = Model::getConnection()->prepare($sql);

        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $response = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$response) {
                return null;
            }

            $this->id = $response->id;
            $this->full_name = $response->full_name;
            $this->birth_date = $response->birth_date;
            $this->email = $response->email;
            $this->profession = $response->profession;
            $this->profession = $response->profession;
            $this->tel = $response->tel;
            $this->cel = $response->cel;
            $this->cel_has_whatsapp = $response->cel_has_whatsapp;
            $this->notify_email = $response->notify_email;
            $this->notify_sms = $response->notify_sms;
            $this->created_at = $response->created_at;
            $this->updated_at = $response->updated_at;

            return $this;
        } else {
            return null;
        }
    }

    public function update()
    {
        $today = date('Y-m-d H:i:s');

        $sql = '
        update users set 
            full_name = ?,
            birth_date = ?,
            email = ?,
            profession = ?, 
            tel = ?, 
            cel = ?,
            cel_has_whatsapp = ?,
            notify_email = ?,
            notify_sms = ?,
            updated_at = ? 
        where 
            id = ?';

        $stmt = Model::getConnection()->prepare($sql);

        $this->updated_at = $today;

        $stmt->bindValue(1, $this->full_name);
        $stmt->bindValue(2, $this->birth_date);
        $stmt->bindValue(3, $this->email);
        $stmt->bindValue(4, $this->profession);
        $stmt->bindValue(5, $this->tel);
        $stmt->bindValue(6, $this->cel);
        $stmt->bindValue(7, intval($this->cel_has_whatsapp));
        $stmt->bindValue(8, intval($this->notify_email));
        $stmt->bindValue(9, intval($this->notify_sms));
        $stmt->bindValue(10, $this->updated_at);
        $stmt->bindValue(11, $this->id);

        return $stmt->execute();
    }

    public function delete()
    {
        $sql = 'update users set deleted = 1 where id = ?';

        $stmt = Model::getConnection()->prepare($sql);

        $stmt->bindValue(1, $this->id);

        $stmt->execute();
    }
}
