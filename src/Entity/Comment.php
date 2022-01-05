<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'integer', options:["default" => 0])]
    private $upVotes;

    #[ORM\Column(type: 'integer', options:["default" => 0])]
    private $downVotes;

    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $account;

    #[ORM\ManyToOne(targetEntity: Game::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUpVotes(): ?int
    {
        return $this->upVotes;
    }

    public function setUpVotes(int $upVotes): self
    {
        $this->upVotes = $upVotes;

        return $this;
    }

    public function getDownVotes(): ?int
    {
        return $this->downVotes;
    }

    public function setDownVotes(int $downVotes): self
    {
        $this->downVotes = $downVotes;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }
}