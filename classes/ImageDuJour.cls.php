<?php

class ImageDuJour extends AccesBd {

    private String $jour;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * retourne les données d'une image
     *
     * @param String $date
     * @return Object
     */
    public function unParDate(String $date) : Object
    {
        $requete = "select img_id, img_fichier, img_description, curdate() img_aujourdhui, img_jour, case when img_jour <= (select min(img_jour) date from image) then null else DATE_ADD(img_jour, INTERVAL -1 DAY) end img_jour_precedent, case when img_jour >= curdate() then null else DATE_ADD(img_jour, INTERVAL 1 DAY) end img_jour_suivant from image where img_jour = ? and img_jour <= curdate()";
        return $this->lireUn($requete, [$date]);
    }

    /**
     * retourn la date de la premiere image
     *
     * @return String
     */
    public function datePremiereImage() : String
    {
        $premiereImage = $this->lireUn("select min(img_jour) date from image");
        return $premiereImage->date;
    }
}