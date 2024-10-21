<?php

namespace App\Entity\HistoryContent;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\ContentType;
use App\Entity\HistoryContent\Api\GetContentByType;
use App\Entity\HistoryImage;
use App\Repository\HistoryContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: HistoryContentRepository::class)]
#[ApiResource(
    shortName: 'History',
    operations: [
        new Get(normalizationContext: ['groups' => 'content:item']),
        new GetCollection(normalizationContext: ['groups' => 'content:list']),
        #new Get(uriTemplate: 'history/type/{type}/{id}',  normalizationContext: ['groups' => 'content:typed_item']),
        new GetCollection(
            uriTemplate: 'history/{id}',
            routeName: 'rwar',
            #normalizationContext: ['groups' => 'content:typed_list'],
            controller: 'App\Controller\HistoryContent\GetContentByType'),
        #new Get(uriTemplate: 'history/type/heroes/{id}',  normalizationContext: ['groups' => 'content:heroes_item']),
        #new GetCollection(uriTemplate: 'history/type/heroes',  normalizationContext: ['groups' => 'content:heroes_list']),
        #new Get(uriTemplate: 'history/type/harovsk/{id}', normalizationContext: ['groups' => 'content:harovsk_item']),
        #new GetCollection(uriTemplate: 'history/type/harovsk',  normalizationContext: ['groups' => 'content:harovsk_list']),
    ],
    paginationEnabled: false,
)]
class HistoryContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['content:list', 'content:item', 'content:typed_item', 'content:typed_list'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ContentType::class, inversedBy: 'historyContents')]
    #[Groups(['content:list', 'content:item', 'content:typed_item', 'content:typed_list'])]
    private ?ContentType $type = null;

    #[ORM\OneToMany(targetEntity: HistoryImage::class, mappedBy: 'historyContent', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['content:list', 'content:item', 'content:typed_item', 'content:typed_list'])]
    private Collection $images;

    #[ORM\Column(length: 2048)]
    #[Groups(['content:list', 'content:item', 'content:typed_item', 'content:typed_list'])]
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

    public function getType(): ?ContentType
    {
        return $this->type;
    }

    public function setType(?ContentType $type): static
    {
        $this->type = $type;

        return $this;
    }

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
