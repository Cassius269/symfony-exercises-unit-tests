<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Author;
use App\Entity\Book;
use App\Enum\CategoryEnum;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{

    #[Test]
    public function it_creates_a_book_with_given_values(): void
    {
        // Arrange
        $title = 'Les Misérables';
        $publishedAt = new \DateTime('1862-10-04');
        $novelCategory = CategoryEnum::Novel;

        $today = new \DateTimeImmutable('now');

        // dd($today->format('d M Y h:i:s'));

        // Act
        $book = new Book();
        $book->setTitle($title)
            ->setCategory($novelCategory)
            ->setPublishedAt($publishedAt)
            ->setCreatedAt($today);

        // Assert
        $this->assertSame($title, $book->getTitle(), 'Les titres ne correspondent pas');
        $this->assertSame($novelCategory, $book->getCategory(), 'Les catégories ne correspondent pas');
        $this->assertSame($publishedAt, $book->getPublishedAt(), 'Les dates de publication ne correspondent pas');
        $this->assertSame($today, $book->getCreatedAt(), 'Les dates de création ne correspondent pas');
    }

    #[Test]
    public function it_adds_an_author_to_a_book(): void
    {
        // Part 1. Author
        // Arrange and Act
        $author = new Author();
        $author->setFirstname("Jean")
            ->setLastname("DUPONT")
            ->setEmail("jean-dupont@email.com")
            ->setPassword("123456789")
            ->setCreatedAt(new \DateTimeImmutable('now'));


        // Part 2. Book
        // Arrange and Act
        $book = new Book();
        $book->setTitle('Les Misérables')
            ->setCategory(CategoryEnum::Novel)
            ->setPublishedAt(new \DateTime('1862-10-04'))
            ->setCreatedAt(new \DateTimeImmutable('now'));

        $book->addAuthor($author);

        // Assert
        $this->assertContains($author, $book->getAuthors());
    }

    #[Test]
    public function it_removes_an_author_from_a_book(): void
    {
        // Part 1. Author
        // Arrange and Act
        $author = new Author();
        $author->setFirstname("Jean")
            ->setLastname("DUPONT")
            ->setEmail("jean-dupont@email.com")
            ->setPassword("123456789")
            ->setCreatedAt(new \DateTimeImmutable('now'));


        // Part 2. Book
        // Arrange
        $title = 'Les Misérables';
        $publishedAt = new \DateTime('1862-10-04');
        $novelCategory = CategoryEnum::Novel;

        $today = new \DateTimeImmutable('now');

        // Act
        $book = new Book();
        $book->setTitle($title)
            ->setCategory($novelCategory)
            ->setPublishedAt($publishedAt)
            ->setCreatedAt($today);

        $book->addAuthor($author);
        // dd($book);
        $book->removeAuthor($author);
        // dd($book);

        // Assert
        $this->assertNotContains($author, $book->getAuthors());
    }
}
