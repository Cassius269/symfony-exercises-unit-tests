<?php

namespace App\Story;

use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public function build(): void
    {
        // Charger les scénarios de peuplement de la base de données de test
        DefaultAuthorStory::load();
        DefaultBookStory::load();

        dump('Peuplement de la base de donnée de test');
    }
}
