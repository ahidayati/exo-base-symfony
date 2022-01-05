<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean', options:["default" => false])]
    private $installed;

    #[ORM\Column(type: 'integer', options:["default" => 0])]
    private $gameTime;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $lastUsed;

    #[ORM\ManyToOne(targetEntity: Game::class)]
    private $game;

    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'libraries')]
    private $account;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstalled(): ?bool
    {
        return $this->installed;
    }

    public function setInstalled(bool $installed): self
    {
        $this->installed = $installed;

        return $this;
    }

    public function getGameTime(): ?int
    {
        return $this->gameTime;
    }

    public function setGameTime(int $gameTime): self
    {
        $this->gameTime = $gameTime;

        return $this;
    }

    public function getLastUsed(): ?\DateTimeInterface
    {
        return $this->lastUsed;
    }

    public function setLastUsed(?\DateTimeInterface $lastUsed): self
    {
        $this->lastUsed = $lastUsed;

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

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}