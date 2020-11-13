<?php

namespace Mpp\GeneraliClientBundle\Model;

use Mpp\GeneraliClientBundle\Exception\GeneraliApiException;

class ApiResponse
{
    /**
     * @var string|null
     */
    private $statut;

    /**
     * @var array<ErrorMessage>|null
     */
    private $messages;

    /**
     * @var mixed|null
     */
    private $donnees;

    /**
     * @var array<Fonds>|null
     */
    private $fonds;

    /**
     * @var Contrat|null
     */
    private $contrat;

    /**
     * @var ModifVlpRetour|null
     */
    private $modifVlpRetour;

    /**
     * Cast object to string (magical call).
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(array_map(function ($message) {
            return (string) $message;
        }, $this->getMessages()));
    }

    /**
     * Get the value of statut.
     *
     * @return string|null
     */
    public function getStatut(): ?string
    {
        return $this->statut;
    }

    /**
     * Set the value of statut.
     *
     * @param string|null $statut
     *
     * @return self
     */
    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get the value of messages.
     *
     * @return array<ErrorMessage>|null
     */
    public function getMessages(): ?array
    {
        return $this->messages;
    }

    /**
     * Set the value of messages.
     *
     * @param array<ErrorMessage>|null $messages
     *
     * @return self
     */
    public function setMessages(?array $messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get the value of donnees.
     *
     * @return mixed|null
     */
    public function getDonnees()
    {
        return $this->donnees;
    }

    /**
     * Set the value of donnees.
     *
     * @param mixed|null $donnees
     *
     * @return self
     */
    public function setDonnees($donnees): self
    {
        $this->donnees = $donnees;

        return $this;
    }

    /**
     * Get the value of fonds.
     *
     * @return array<Fonds>|null
     */
    public function getFonds(): ?array
    {
        return $this->fonds;
    }

    /**
     * Set the value of fonds.
     *
     * @param array<Fonds>|null $fonds
     *
     * @return self
     */
    public function setFonds(?array $fonds): self
    {
        $this->fonds = $fonds;

        return $this;
    }

    /**
     * Get the value of contrat.
     *
     * @return Contrat|null
     */
    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    /**
     * Set the value of contrat.
     *
     * @param Contrat|null $contrat
     *
     * @return self
     */
    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * Get the value of modifVlpRetour.
     *
     * @return ModifVlpRetour|null
     */
    public function getModifVlpRetour(): ?ModifVlpRetour
    {
        return $this->modifVlpRetour;
    }

    /**
     * Set the value of modifVlpRetour.
     *
     * @param ModifVlpRetour|null $modifVlpRetour
     *
     * @return self
     */
    public function setModifVlpRetour(?ModifVlpRetour $modifVlpRetour): self
    {
        $this->modifVlpRetour = $modifVlpRetour;

        return $this;
    }

    /**
     * Build and return generali api exception.
     *
     * @return GeneraliApiException
     */
    public function getException(): GeneraliApiException
    {
        return new GeneraliApiException((string) $this);
    }
}
