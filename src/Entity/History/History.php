<?php

namespace App\Entity\History;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Entity\History\HistoryMediaType\HistoryImage;
use App\Repository\History\HistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: HistoryRepository::class)]
#[ApiResource(
    shortName: 'History',
    operations: [
        new Get(normalizationContext: ['groups' => 'content:item']),
        new GetCollection(normalizationContext: ['groups' => 'content:list']),

        new GetCollection(
            uriTemplate: 'history/{contentType}',
            uriVariables: [
                'contentType' => new Link(
                    identifiers: ['apiResource'],
                    fromClass: ContentType::class,
                    toProperty: 'type',
                    description: 'Type of history content: [\'heroes\', \'harovsk\']'
                )
            ],
            normalizationContext: ['groups' => 'content:list'],
        ),
    ],
    paginationEnabled: false,
)]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['content:list', 'content:item'])]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: ContentType::class)]
    #[Groups(['content:list', 'content:item'])]
    private ?ContentType $type = null;


    #[ORM\OneToMany(targetEntity: HistoryImage::class, mappedBy: 'historyContent', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['content:list', 'content:item'])]
    private Collection $images;


    #[ORM\Column(length: 2048)]
    #[Groups(['content:list', 'content:item'])]
    private ?string $description = null;


                    /*-------------------------------------------*
                     *          Entity field accessors.          *
                     *-------------------------------------------*/
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }


    public function setType(?ContentType $type): static
    {
        $this->type = $type;

        return $this;
    }
    public function getType(): ?ContentType
    {
        return $this->type;
    }


                /*------------------------------------------------*
                 *          Entity Media Type accessors.          *
                 *------------------------------------------------*/
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
