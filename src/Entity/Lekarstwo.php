<?php

namespace App\Entity;

use App\Repository\LekarstwoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LekarstwoRepository::class)]
class Lekarstwo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nazwa_leku;

    #[ORM\Column(type: 'string', length: 255)]
    private $producent;

    #[ORM\Column(type: 'date')]
    private $data_utworzenia;

    #[ORM\Column(type: 'date')]
    private $data_modyfikacji;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwaLeku(): ?string
    {
        return $this->nazwa_leku;
    }

    public function setNazwaLeku(string $nazwa_leku): self
    {
        $this->nazwa_leku = $nazwa_leku;

        return $this;
    }

    public function getProducent(): ?string
    {
        return $this->producent;
    }

    public function setProducent(string $producent): self
    {
        $this->producent = $producent;

        return $this;
    }

    public function getDataUtworzenia(): ?\DateTimeInterface
    {
        return $this->data_utworzenia;
    }

    public function setDataUtworzenia(\DateTimeInterface $data_utworzenia): self
    {
        $this->data_utworzenia = $data_utworzenia;

        return $this;
    }

    public function getDataModyfikacji(): ?\DateTimeInterface
    {
        return $this->data_modyfikacji;
    }

    public function setDataModyfikacji(\DateTimeInterface $data_modyfikacji): self
    {
        $this->data_modyfikacji = $data_modyfikacji;

        return $this;
    }
}
