<?php

namespace App\Enum;

enum Category: string
{
    case Nouvel = "roman";
    case Adventure = "aventure";
    case Poetry = "poésie";
    case Biography = "biographie";
    case ArtAndPhotographie = "Art and Photography";
    case Dictionnary = "dictionnaire";
    case Encyclopedia = "encyclopédie";
}
