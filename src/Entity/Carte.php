<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use App\Entity\Regions;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteRepository::class)]
#[ORM\Index(name: 'carte', columns: ['titre_pays_c', 'capitale_c','desc_pays_c'], flags: ['fulltext'])]
#[Vich\Uploadable]
class Carte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $Titre_PaysC;

    #[ORM\Column(type: 'string', length: 100)]
    private $CapitaleC;

    #[ORM\Column(type: 'string', length: 5000)]
    private $Desc_PaysC;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    #[Vich\UploadableField(mapping: 'imagesarticles', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string')]
    private ?string $imageName = null;

    #[ORM\OneToMany(mappedBy: 'Carte_R_titre', targetEntity: Regions::class)]
    private $regions;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitrePaysC(): ?string
    {
        return $this->Titre_PaysC;
    }

    public function setTitrePaysC(string $Titre_PaysC): self
    {
        $this->Titre_PaysC = $Titre_PaysC;

        return $this;
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    
    public function getCapitaleC(): ?string
    {
        return $this->CapitaleC;
    }

    public function setCapitaleC(string $CapitaleC): self
    {
        $this->CapitaleC = $CapitaleC;

        return $this;
    }

    public function getDescPaysC(): ?string
    {
        return $this->Desc_PaysC;
    }

    public function setDescPaysC(string $Desc_PaysC): self
    {
        $this->Desc_PaysC = $Desc_PaysC;

        return $this;
    }


    /**
     * @return Collection<int, Regions>
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Regions $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
            $region->setCarteRTitre($this);
        }

        return $this;
    }

    public function removeRegion(Regions $region): self
    {
        if ($this->regions->removeElement($region)) {
            // set the owning side to null (unless already changed)
            if ($region->getCarteRTitre() === $this) {
                $region->setCarteRTitre(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->Titre_PaysC;
    }
 
    public function getallcountries() :?string
    {
        //return tostring
        return $this->Titre_PaysC;
    }
}
