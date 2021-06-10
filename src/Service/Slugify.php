<?php


namespace App\Service;


class Slugify
{

    public function generate(string $input) : string
    {
        //Efface les espaces vide
        $input = trim($input);
        //Remplace chaque espace vide par un - tiret
        $input = str_replace(' ', '-', $input);
        //Ne suprimme pas les caractères avec accents
        $input = htmlentities($input, ENT_COMPAT, "UTF-8");
        $input = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','$1',$input);
        //Efface les caracteres de ponctuation
        $input = preg_replace('/[^a-zA-Z0-9_%\[().\]\\/-]/s', '', $input);
        //Laisse un tiret seulement s'il y'en a plusieurs à la suite
        $input = preg_replace('@[-]+@','-', $input);
        //Efface toutes les majuscules
        $input = strtolower($input);

        return html_entity_decode($input);
    }

}