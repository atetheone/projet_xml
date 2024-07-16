<?php

class Film {
    public $titre;
    public $dureeHeures;
    public $dureeMinutes;
    public $genres = [];
    public $realisateur;
    public $langue;
    public $acteurs = [];
    public $annee;
    public $notes = [];
    public $synopsis;
    public $horaires = [];

    public function __construct($filmElement) {
        $this->titre = (string) $filmElement->titre;
        $this->dureeHeures = (string) $filmElement->durée['heures'];
        $this->dureeMinutes = (string) $filmElement->durée['minutes'];
        foreach ($filmElement->genres->genre as $genre) {
            $this->genres[] = (string) $genre;
        }
        $this->realisateur = (string) $filmElement->réalisateur;
        $this->langue = (string) $filmElement->langue;
        foreach ($filmElement->acteurs->acteur as $acteur) {
            $this->acteurs[] = (string) $acteur;
        }
        $this->annee = (string) $filmElement->année;
        foreach ($filmElement->notes->note as $note) {
            $this->notes[] = ['source' => (string) $note['source'], 'note' => (string) $note];
        }
        $this->synopsis = (string) $filmElement->synopsis;
        foreach ($filmElement->horaires->horaire as $horaire) {
            $this->horaires[] = [
                'jour' => (string) $horaire['jour'],
                'heure' => (string) $horaire['heure'],
                'minute' => (string) $horaire['minute']
            ];
        }
    }

    
}
?>
