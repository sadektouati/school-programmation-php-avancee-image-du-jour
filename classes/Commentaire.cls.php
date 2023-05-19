<?php
class Commentaire extends AccesBd {
    private int $idIdj;

    function __construct($idIdj){
        $this->idIdj = $idIdj;
        parent::__construct();
    }

    /**
     * retourne le nombre d'aime d'une image
     *
     * @return Int
     */
    public function obtenirNombreAime() : Int
    {
        $aimes = $this->lireUn("select count(*) nombre_aime from commentaire where com_img_id_ce = ? and com_texte is null", [$this->idIdj]);
        return $aimes->nombre_aime;
    }

    /**
     * les comentataires ecrits sur une image
     *
     * @return Array
     */
    public function toutAvecVote() : Array
    {
       return $this->lireTout("select com_texte as texte, (select count(case when vot_updown = 1 then 1 else null end) from vote where vot_com_id_ce=commentaire.com_id) as vote_up, (select count(case when vot_updown = -1 then -1 else null end) from vote where vot_com_id_ce=commentaire.com_id) as vote_down from commentaire where com_img_id_ce = ? and com_texte is not null", [$this->idIdj]);
    }

}