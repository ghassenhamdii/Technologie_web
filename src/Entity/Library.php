<?php
namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $website = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;  // Changement ici

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): static
    {
        $this->website = $website;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface   // Changement ici
    {
        return $this->dateCreation;  // Changement ici
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static   // Changement ici
    {
        $this->dateCreation = $dateCreation;  // Changement ici
        return $this;
    }
}
