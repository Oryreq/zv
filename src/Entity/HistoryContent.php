<?php

namespace App\Entity;

use App\Repository\HistoryContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: HistoryContentRepository::class)]
class HistoryContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    ##[ORM\Column(length: 255)]
    #[ORM\ManyToOne(targetEntity: ContentType::class, inversedBy: 'historyContents')]
    private ?ContentType $contentType = null;

    /**
     * @var Collection<int, HistoryImage>
     */
    #[ORM\OneToMany(targetEntity: HistoryImage::class, mappedBy: 'historyContent', orphanRemoval: true, cascade: ['persist'])]
    private Collection $images;

    #[ORM\Column(length: 2048)]
    private ?string $description = null;


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }


    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentType(): ?ContentType
    {
        return $this->contentType;
    }

    public function setContentType(?ContentType $contentType): static
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * @return Collection<int, HistoryImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(HistoryImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setHistoryContent($this);
        }

        return $this;
    }

    public function removeImage(HistoryImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getHistoryContent() === $this) {
                $image->setHistoryContent(null);
            }
        }

        return $this;
    }
}
