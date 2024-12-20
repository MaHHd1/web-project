<?php
class Commentaire {
    private ?int $id;
    private ?int $id_user;
    private ?int $id_article;
    private ?string $comment_text;
    private ?DateTime $created_at;

    // Constructor
    public function __construct(?int $id = null, ?int $id_user = null, ?int $id_article = null, ?string $comment_text = null, ?DateTime $created_at = null) {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_article = $id_article;
        $this->comment_text = $comment_text;
        $this->created_at = $created_at ?? new DateTime(); // Si null, crée une nouvelle instance de DateTime
    }

    // Getters and setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getIdUser(): ?int {
        return $this->id_user;
    }

    public function setIdUser(?int $id_user): void {
        $this->id_user = $id_user;
    }

    public function getIdArticle(): ?int {
        return $this->id_article;
    }

    public function setIdArticle(?int $id_article): void {
        $this->id_article = $id_article;
    }

    public function getCommentText(): ?string {
        return $this->comment_text;
    }

    public function setCommentText(?string $comment_text): void {
        $this->comment_text = $comment_text;
    }

    public function getCreatedAt(): ?DateTime {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): void {
        $this->created_at = $created_at;
    }

    // Convert comment to array for database insertion
    public function toArray(): array {
        return [
            'id_user' => $this->id_user,
            'id_articles' => $this->id_article,
            'comment_text' => $this->comment_text,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null
        ];
    }
}
?>
