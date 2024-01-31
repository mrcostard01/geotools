<?php

namespace App\Entity;

use App\Repository\ModificationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModificationsRepository::class)]
class Modifications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $id;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'modifications')]
    private $Pseudo_M_id;

    #[ORM\Column(type: 'string', length: 5000, nullable: true)]
    private $Modif_Pays_descM;

    #[ORM\Column(type: 'string', length: 5000, nullable: true)]
    private $Modif_Regions_descM;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ancienneidpays;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ancienneidregions;

    public function __construct()
    {
        $this->Pseudo_M_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getPseudoMId(): Collection
    {
        return $this->Pseudo_M_id;
    }

    public function addPseudoMId(user $pseudoMId): self
    {
        if (!$this->Pseudo_M_id->contains($pseudoMId)) {
            $this->Pseudo_M_id[] = $pseudoMId;
        }

        return $this;
    }

    public function removePseudoMId(user $pseudoMId): self
    {
        $this->Pseudo_M_id->removeElement($pseudoMId);

        return $this;
    }

    public function getModifPaysDescM(): ?string
    {
        return $this->Modif_Pays_descM;
    }

    public function setModifPaysDescM(?string $Modif_Pays_descM): self
    {
        $this->Modif_Pays_descM = $Modif_Pays_descM;

        return $this;
    }

    public function getModifRegionsDescM(): ?string
    {
        return $this->Modif_Regions_descM;
    }

    public function setModifRegionsDescM(?string $Modif_Regions_descM): self
    {
        $this->Modif_Regions_descM = $Modif_Regions_descM;

        return $this;
    }

    public function getAncienneidpays(): ?int
    {
        return $this->ancienneidpays;
    }

    public function setAncienneidpays(?int $ancienneidpays): self
    {
        $this->ancienneidpays = $ancienneidpays;

        return $this;
    }

    public function getAncienneidregions(): ?int
    {
        return $this->ancienneidregions;
    }

    public function setAncienneidregions(?int $ancienneidregions): self
    {
        $this->ancienneidregions = $ancienneidregions;

        return $this;
    }
}
