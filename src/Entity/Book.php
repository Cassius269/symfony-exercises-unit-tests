<?php

namespace App\Entity;

use App\Enum\CategoryEnum;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator('doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(
        min: 4,
        minMessage: 'Doit avoir au minimum 3 caractères',
        max: 50,
        maxMessage: 'Doit avoir au maximum 50 caractères'
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Assert\DateTime(
        message: 'La date de publication doit être valide'
    )]
    private ?\DateTime $publishedAt = null;

    #[ORM\Column]
    #[Assert\DateTime(
        message: 'La date de création de la donnée doit être valide'
    )]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\DateTime(
        message: 'La date de mise à jour doit être valide'
    )]
    private ?\DateTime $updatedAt = null;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private Collection $authors;

    #[ORM\Column(enumType: CategoryEnum::class)]
    #[Assert\Type(
        CategoryEnum::class,
        message: 'Doit être un choix de l\'énumération des catégories'
    )]
    private ?CategoryEnum $category = null;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPublishedAt(): ?\DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTime $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        $this->authors->removeElement($author);

        return $this;
    }

    public function getCategory(): ?CategoryEnum
    {
        return $this->category;
    }

    public function setCategory(CategoryEnum $category): static
    {
        $this->category = $category;

        return $this;
    }
}
