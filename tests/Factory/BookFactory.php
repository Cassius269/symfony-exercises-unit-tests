<?php

namespace App\Tests\Factory;

use App\Entity\Book;
use App\Enum\CategoryEnum;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentObjectFactory<Book>
 */
final class BookFactory extends PersistentObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    #[\Override]
    public static function class(): string
    {
        return Book::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {

        return [
            'title' => self::faker()->text(50),
            'category' => self::faker()->randomElement(CategoryEnum::cases()),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => null
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        // Gérer les relations many-to-many entre Book et Author
        return $this->afterInstantiate(function (Book $book) {
            $author = AuthorFactory::createOne();
            $book->addAuthor($author);
        });;
    }
}
