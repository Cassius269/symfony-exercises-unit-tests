<?php

namespace App\Enum;

enum CategoryEnum: string
{
    case Nouvel = "roman";
    case Adventure = "aventure";
    case Poetry = "poésie";
    case Biography = "biographie";
    case ArtAndPhotographie = "Art and Photography";
    case Dictionnary = "dictionnaire";
    case Encyclopedia = "encyclopédie";
}
