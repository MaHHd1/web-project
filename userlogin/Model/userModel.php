<?php
class User
{
    private $id;
    private $name;
    private $mail;
    private $psw;

    public function __construct($id = null, $name = null, $mail = null, $psw = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->mail = $mail;
        $this->psw = $psw;
    }

    // Getters and Setters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getMail() { return $this->mail; }
    public function getPsw() { return $this->psw; }

    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setMail($mail) { $this->mail = $mail; }
    public function setPsw($psw) { $this->psw = $psw; }
}
?>
