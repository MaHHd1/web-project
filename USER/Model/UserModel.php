<?php

class User
{
    private $id;
    private $mail;
    private $psw;

    public function __construct($mail = null, $psw = null, $id = null)
    {
        $this->id = $id;
        $this->mail = $mail;
        $this->psw = $psw;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getPsw()
    {
        return $this->psw;
    }
}
?>





