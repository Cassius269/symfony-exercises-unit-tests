<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Author;
use App\Entity\Book;
use App\Enum\CategoryEnum;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

class AuthorTest extends TestCase
{
    #[Test]
    public function it_creates_an_author_with_given_values(): void
    {
        // Arrange
        $firstname = 'Jean';
        $lastname = 'DUPONT';
        $email = "email@test.com";
        $password = "123456789";
        $roles = ['ROLE_AUTHOR'];
        $today = new \DateTimeImmutable('today');

        // Act
        $author = new Author();
        $author->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPassword($password)
            ->setRoles($roles)
            ->setCreatedAt($today);

        // dd($author->getRoles());

        // Assert
        $this->assertSame($firstname, $author->getFirstname());
        $this->assertSame($lastname, $author->getLastname());
        $this->assertSame($email, $author->getEmail(), 'L\'email actuel ne correpond pas à l\'email esperé'); // vérifier l'égalité stricte de l'email esperé
        $this->assertSame($password, $author->getPassword(), 'Le mot de passe actuel ne correpond pas au mot de passe esperé');
        $this->assertContains('ROLE_AUTHOR', $author->getRoles()); // vérifier que l'auteur a le rôle ROLE_AUTHOR
        $this->assertContains('ROLE_USER', $author->getRoles()); // vérifier que l'auteur a en plus le rôle par défaut ROLE_USER
        $this->assertEquals($today->format("Y-m-d H:i:s"), $author->getCreatedAt()->format("Y-m-d H:i:s"));
    }

    #[Test]
    public function it_uses_default_role_when_not_provided(): void
    {
        // Arrange
        $firstname = 'Jean';
        $lastname = 'DUPONT';
        $email = "email@test.com";
        $password = "123456789";
        $today = new \DateTimeImmutable('today');

        // Act
        $author = new Author();
        $author->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPassword($password)
            ->setCreatedAt($today);

        // Assert 
        $this->assertSame($firstname, $author->getFirstname());
        $this->assertSame($lastname, $author->getLastname());
        $this->assertSame($email, $author->getEmail(), 'L\'email actuel ne correpond pas à l\'email esperé'); // vérifier l'égalité stricte de l'email esperé
        $this->assertSame($password, $author->getPassword(), 'Le mot de passe actuel ne correpond pas au mot de passe esperé');
        $this->assertEquals($today->format("Y-m-d H:i:s"), $author->getCreatedAt()->format("Y-m-d H:i:s"));
        $this->assertContains('ROLE_AUTHOR', $author->getRoles()); // vérifier que l'auteur a le rôle ROLE_AUTHOR
        $this->assertContains('ROLE_USER', $author->getRoles());
    }

    #[Test]
    #[DataProvider('invalidEmailData')]
    public function it_throws_exception_when_email_is_invalid(string $email): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains("$email doit être un email valide");

        $author = new Author();
        $author->setEmail($email);
    }

    // Provider de valeurs d'emails incorrectes
    public static function invalidEmailData(): iterable
    {
        yield ['test'];
        yield ['test@email'];
        yield ['@email.fr'];
    }

    #[Test]
    public function it_adds_an_author_to_a_book(): void
    {
        // Part 1. author
        // Arrange
        $firstname = 'Jean';
        $lastname = 'DUPONT';
        $email = "email@test.com";
        $password = "123456789";
        $today = new \DateTimeImmutable('today');

        // Act
        $author = new Author();
        $author->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPassword($password)
            ->setCreatedAt($today);

        // Part 2. book
        // Arrange
        $title = 'Tatarataratara';
        $novelCategory = CategoryEnum::Novel;
        // dd($novelCategory);
        $yesterday = new \DateTime('yesterday');

        // Act
        $book = new Book();
        $book->setTitle($title)
            ->setPublishedAt($yesterday)
            ->setCategory($novelCategory)
            ->addAuthor($author)
            ->setCreatedAt($today);

        $author->addBook($book);

        // dd($book->getAuthors()[0]);
        // Assert
        $this->assertContains($author, $book->getAuthors(), "Auteur similaire non similaire");
        $this->assertContains($book, $author->getBooks(), "Livre similaire non trouvé");
    }
}
