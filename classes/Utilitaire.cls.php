<?php

class Utilitaire{

    /**
     * formatage de la date
     *
     * @param String $date
     * @return string
     */
    public static function dateFormatee(String $date) : string
    {
        //Sur windows fr-FR sur *nix c'est le fr_FR
        //Certainement il y a une meilleure solution ... peut etre objet Date...
        setlocale(LC_TIME, 'fr-CA');
        return strftime("%A, %e %B %Y", strtotime($date));
    }

    /**
     * Calcul de de taux de votes positifs
     *
     * @param integer $votesPositifs
     * @param integer $votesNegatifs
     * @return float
     */
    public static function tauxVotesPositifs(int $votesPositifs, int $votesNegatifs) : float
    {
        if($votesNegatifs == 0) {
            return 1;
        } else {
            $total = $votesPositifs + $votesNegatifs;
         return $votesPositifs /  ($total == 0 ? 1 : $total);
        }
    }
}