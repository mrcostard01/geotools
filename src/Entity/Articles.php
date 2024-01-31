<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
#[ORM\Index(name: 'articles', columns: ['titre_article_a', 'resume_articlea'], flags: ['fulltext'])]
#[Vich\Uploadable]

class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Titre_ArticleA;

    #[ORM\Column(type: 'string', length: 5000)]
    private $Texte_ArticleA;

    #[Vich\UploadableField(mapping: 'imagesarticles', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string')]
    private ?string $imageName = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'articles')]
    private $Pseudo_M_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Resume_articlea;

    public function __construct()
    {
        $this->Pseudo_M_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    public function getTitreArticleA(): ?string
    {
        return $this->Titre_ArticleA;
    }


    public function setTitreArticleA(string $Titre_ArticleA): self
    {
        $this->Titre_ArticleA = $Titre_ArticleA;

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
    public function getTexteArticleA(): ?string
    {
        return $this->Texte_ArticleA;
    }

    public function setTexteArticleA(string $Texte_ArticleA): self
    {
        $this->Texte_ArticleA = $Texte_ArticleA;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPseudoMId(): Collection
    {
        return $this->Pseudo_M_id;
    }

    public function addPseudoMId(User $pseudoMId): self
    {
        if (!$this->Pseudo_M_id->contains($pseudoMId)) {
            $this->Pseudo_M_id[] = $pseudoMId;
        }

        return $this;
    }

    public function removePseudoMId(User $pseudoMId): self
    {
        $this->Pseudo_M_id->removeElement($pseudoMId);

        return $this;
    }

    public function getResumeArticlea(): ?string
    {
        return $this->Resume_articlea;
    }

    public function setResumeArticlea(string $Resume_articlea): self
    {
        $this->Resume_articlea = $Resume_articlea;

        return $this;
    }
    
}
