<?php

namespace App\Entity;

use App\Entity\Carte;

use App\Repository\RegionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionsRepository::class)]
class Regions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Carte::class, inversedBy: 'regions')]
    private $carte_r_titre;

    #[ORM\Column(type: 'string', length: 5000)]
    private $Desc_RegionsR;

    #[ORM\Column(type: 'string', length: 100)]
    private $Regions_Titre_R;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarteRTitre(): ?Carte
    {
        return $this->carte_r_titre;
    }

    public function setCarteRTitre(?Carte $carte_r_titre): self
    {
        $this->carte_r_titre = $carte_r_titre;

        return $this;
    }

    public function getDescRegionsR(): ?string
    {
        return $this->Desc_RegionsR;
    }

    public function setDescRegionsR(string $Desc_RegionsR): self
    {
        $this->Desc_RegionsR = $Desc_RegionsR;

        return $this;
    }

    public function getRegionsTitreR(): ?string
    {
        return $this->Regions_Titre_R;
    }

    public function setRegionsTitreR(string $Regions_Titre_R): self
    {
        $this->Regions_Titre_R = $Regions_Titre_R;

        return $this;
    }
       
}
