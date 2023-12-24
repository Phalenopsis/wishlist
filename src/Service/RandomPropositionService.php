<?php

namespace App\Service;

use App\Entity\Proposition;
use App\Entity\WishList;

class RandomPropositionService
{
    public function getRandomProposition(WishList $wishList): Proposition
    {
        $choices = [];
        foreach ($wishList->getPropositions() as $proposition){
            if($proposition->getState() === 'Created'){
                $choices[] = $proposition;
            }
        }
        return $choices[array_rand($choices)];
    }
}
