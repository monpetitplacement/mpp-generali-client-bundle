<?php

namespace Mpp\GeneraliClientBundle\Model;

class VlpMontant
{
    const VLP_MONTANT_PERIODICITE_HEBDOMADAIRE = 'HEBDOMADAIRE';
    const VLP_MONTANT_PERIODICITE_MENSUELLE = 'MENSUELLE';
    const VLP_MONTANT_PERIODICITE_TRIMESTRIELLE = 'TRIMESTRIELLE';
    const VLP_MONTANT_PERIODICITE_SEMESTRIELLE = 'SEMESTRIELLE';
    const VLP_MONTANT_PERIODICITE_ANNUELLE = 'ANNUELLE';

    /**
     * @var float|null
     */
    private $montant;

    /**
     * @var string|null
     */
    private $periodicite;

    /**
     * Get the value of montant.
     *
     * @return float|null
     */
    public function getMontant(): ?float
    {
        return $this->montant;
    }

    /**
     * Set the value of montant.
     *
     * @param float|null $montant
     *
     * @return self
     */
    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get the value of periodicite.
     *
     * @return string|null
     */
    public function getPeriodicite(): ?string
    {
        return $this->periodicite;
    }

    /**
     * Set the value of periodicite.
     *
     * @param string|null $periodicite
     *
     * @return self
     */
    public function setPeriodicite(?string $periodicite): self
    {
        $this->periodicite = $periodicite;

        return $this;
    }
}
