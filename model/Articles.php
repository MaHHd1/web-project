<?php

class Articles {
    private ?int $id;
    private ?string $titre;
    private ?string $contenu_txt;
    private ?string $contenu_img;
    private ?DateTime $date_creation;

    // Constructor
    public function __construct( ?int $id = null, ?string $titre = null, ?string $contenu_txt = null, ?string $contenu_img = null, ?DateTime $date_creation = null) {
   
            // Initialisation à partir du tableau de données
            $this->id = $id;
            $this->titre = $titre;
            $this->contenu_txt =$contenu_txt;
            $this->contenu_img = $contenu_img;
            $this->date_creation = $date_creation;
      
    }

    // Getters and Setters
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

    public function getContenu_txt(): ?string {
        return $this->contenu_txt;
    }

    public function setContenu_txt(?string $contenu_txt): void {
        $this->contenu_txt = $contenu_txt;
    }

    public function getContenu_img(): ?string {
        return $this->contenu_img;
    }

    public function setContenu_img(?string $contenu_img): void {
        $this->contenu_img = $contenu_img;
    }

    public function getDate_creation(): ?DateTime {
        return $this->date_creation;
    }

    public function setDate_creation(?DateTime $date_creation): void {
        $this->date_creation = $date_creation;
    }
}

?>
