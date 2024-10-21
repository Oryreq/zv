<?php

namespace App\Entity;

use App\Entity\HistoryContent\HistoryContent;
use App\Repository\ContentTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: ContentTypeRepository::class)]
class ContentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['content:list', 'content:item', 'content:typed_item', 'content:typed_list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['content:list', 'content:item', 'content:typed_item', 'content:typed_list'])]
    private ?string $value = null;

    #[ORM\OneToMany(targetEntity: HistoryContent::class, mappedBy: 'type')]
    private Collection $historyContents;


    #[ORM\Column(length: 255)]
    #[Groups(['content:list', 'content:item', 'content:typed_item', 'content:typed_list'])]
    private ?string $apiResource = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getHistoryContents(): Collection
    {
        return $this->historyContents;
    }

    public function addProduct(HistoryContent $product): static
    {
        if (!$this->historyContents->contains($product)) {
            $this->historyContents->add($product);
            $product->setType($this);
        }

        return $this;
    }

    public function removeProduct(HistoryContent $product): static
    {
        if ($this->historyContents->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getType() === $this) {
                $product->setType(null);
            }
        }

        return $this;
    }

    public function getApiResource(): ?string
    {
        return $this->apiResource;
    }

    public function setApiResource(?string $apiResource): void
    {
        $this->apiResource = $apiResource;
    }


}
