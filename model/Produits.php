<?php
class Produit
{
    private ?int $id = null;
    private ?string $nom = null;
    private ?string $description= null;
    private ?float $pass = null;
    private ?string $lieu = null;
    private ?string $date = null;
    private ?string $datef = null;
    private ?string $image = null;

    public function __construct(String $nom, String $description, float $pass ,String $lieu,String $date, String $datef, string $image)
    {
        $this->nom = $nom;
        $this->description = $description;
        $this->pass = $pass;
        $this->lieu = $lieu;
        $this->date = $date;
        $this->datef = $datef;
        $this->image = $image;
    }
    //getters pour accéder aux donnees un produit
    public function getProduitId(): ?int
    {
        return $this->id;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getPass(): ?float
    {
        return $this->pass;
    }
    public function getLieu(): ?string
    {
        return $this->lieu;
    }
    public function getDate(): ?string
    {
        return $this->date;
    }
    public function getDatef(): ?string
    {
        return $this->datef;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }
    //stters pous MAJ les donnes de produit
    public function setProduitId(int $id): void
    {
        $this->id = $id;
    }
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    
    public function setPass(float $pass): void
    {
        $this->pass = $pass;
    }
    public function setLieu(float $lieu): void
    {
        $this->lieu = $lieu;
    }
    public function setDate(float $date): void
    {
        $this->date = $date;
    }
    public function setDatef(float $datef): void
    {
        $this->datef = $datef;
    }
    public function setImage(string $image): void
    {
        $this->image = $image;
    }
}
