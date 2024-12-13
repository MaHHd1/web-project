<?php

class User
{
    private $id;
    private $mail;
    private $psw;
    private $uname;
    private $country;

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

    public function getUname()
    {
        return $this->uname;
    }

    public function setUname($uname)
    {
        $this->uname = $uname;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }
}
?>
