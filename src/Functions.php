<?php

namespace App;

 class Functions {

    public function formatPrice($number)
    {
        return number_format($number, 0, ',', ' ');
    }

    // affiche les horaires d'ouverture
    public function creneaux_html(array $creneaux)
    {
        if (empty($creneaux)) {
            return 'Fermé';
        }
        /* autre possibilité :
        if (count($creneaux) === 0) {
            return 'Fermé';
        } */
        $phrases = [];
        foreach ($creneaux as $creneau) {
            $phrases[] = "de <strong>{$creneau[0]}h</strong> à <strong>{$creneau[1]}h</strong>";
        }
        return 'Ouvert ' . implode(' et ', $phrases);
    }

    // retourne vrai si l'heure se trouve dans les heures d'ouverture, sinon faux
    public function in_creneaux(int $heure, array $creneaux): bool
    {
        foreach ($creneaux as $creneau) {
            $debut = $creneau[0];
            $fin = $creneau[1];
            if ($heure >= $debut && $heure < $fin) {
                return true;
            }
        }
        return false;
    }
}