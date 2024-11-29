<?php
class Reservation
{
    private ?int $id_reservation = null; // Clé primaire
    private ?int $id = null; // Clé étrangère
    private ?string $nom_p = null;
    private ?string $numero = null;
    private ?string $mail = null;

    public function __construct(int $id, string $nom_p, string $numero, string $mail)
    {
        $this->id = $id;
        $this->nom_p = $nom_p;
        $this->numero = $numero;
        $this->mail = $mail;
    }

    // Getters
    public function getIdReservation(): ?int
    {
        return $this->id_reservation;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->nom_p;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    // Setters
    public function setIdReservation(int $id_reservation): void
    {
        $this->id_reservation = $id_reservation;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNomP(string $nom_p): void
    {
        $this->nom_p = $nom_p;
    }

    public function setNumero(string $numero): void
    {
        $this->numero = $numero;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }
}
?>
