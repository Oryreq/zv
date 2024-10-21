<?php

namespace App\Entity;

use App\Repository\ContentTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ContentTypeRepository::class)]
class ContentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\OneToMany(targetEntity: HistoryContent::class, mappedBy: 'contentType')]
    private Collection $historyContents;


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

    /**
     * @return Collection<int, HistoryContent>
     */
    public function getHistoryContents(): Collection
    {
        return $this->historyContents;
    }

    public function addProduct(HistoryContent $product): static
    {
        if (!$this->historyContents->contains($product)) {
            $this->historyContents->add($product);
            $product->setContentType($this);
        }

        return $this;
    }

    public function removeProduct(HistoryContent $product): static
    {
        if ($this->historyContents->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getContentType() === $this) {
                $product->setContentType(null);
            }
        }

        return $this;
    }
}
