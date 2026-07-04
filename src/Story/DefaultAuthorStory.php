<?php

namespace App\Story;

use App\Tests\Factory\AuthorFactory;
use Zenstruck\Foundry\Story;

final class DefaultAuthorStory extends Story
{
    public function build(): void
    {
        AuthorFactory::createMany(100);

        dump('Story AuthorStory exécutée');
    }
}
