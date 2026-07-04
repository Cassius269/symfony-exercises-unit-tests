<?php

namespace App\Story;

use App\Tests\Factory\BookFactory;
use Zenstruck\Foundry\Story;

final class DefaultBookStory extends Story
{
    public function build(): void
    {
        BookFactory::createMany(100);
        dump('Story BookStory exécutée');
    }
}
