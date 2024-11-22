<?php

class Produit {
    private ?int $id;
    private ?string $nomproduit;
    private ?float $prix;
    private ?int $quantite;
    private ?string $image;

    // Constructor
    public function __construct(?int $id = null, ?string $nomproduit = null, ?float $prix = null, ?int $quantite = null, ?string $image = null) {
        $this->id = $id;
        $this->nomproduit = $nomproduit;
        $this->prix = $prix;
        $this->quantite = $quantite;
        $this->image = $image;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getNomProduit(): ?string {
        return $this->nomproduit;
    }

    public function setNomProduit(?string $nomproduit): void {
        $this->nomproduit = $nomproduit;
    }

    public function getPrix(): ?float {
        return $this->prix;
    }

    public function setPrix(?float $prix): void {
        $this->prix = $prix;
    }

    public function getQuantite(): ?int {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): void {
        $this->quantite = $quantite;
    }

    public function getImage(): ?string {
        return $this->image;
    }

    public function setImage(?string $image): void {
        $this->image = $image;
    }
}

?>
