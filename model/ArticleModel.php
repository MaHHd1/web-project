<?php

class Article {
    private ?int $id;
    private ?string $titre;
    private ?string $contenu_txt;
    private ?string $contenu_img; 
    private ?DateTime $date_creation;

    // Constructeur
    public function __construct(?int $id = null, ?string $titre = null, ?string $contenu_txt = null, ?string $contenu_img = null, ?DateTime $date_creation = null) {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu_txt = $contenu_txt;
        $this->contenu_img = $contenu_img;
        $this->date_creation = $date_creation;
    }

    // Getters et Setters

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getTitre(): ?string {
        return $this->titre;
    }

    public function setTitre(?string $titre): void {
        $this->titre = $titre;
    }

    public function getContenuTxt(): ?string {
        return $this->contenu_txt;
    }

    public function setContenuTxt(?string $contenu_txt): void {
        $this->contenu_txt = $contenu_txt;
    }

    public function getContenuImg(): ?string {
        return $this->contenu_img;
    }

    public function setContenuImg(?string $contenu_img): void {
        $this->contenu_img = $contenu_img;
    }

    public function getDateCreation(): ?DateTime {
        return $this->date_creation;
    }

    public function setDateCreation(?DateTime $date_creation): void {
        $this->date_creation = $date_creation;
    }
}

?>
