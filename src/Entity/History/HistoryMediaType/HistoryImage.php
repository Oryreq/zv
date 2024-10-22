<?php

namespace App\Entity\History\HistoryMediaType;

use App\Entity\History\History;
use App\Repository\History\HistoryImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;


#[ORM\Entity(repositoryClass: HistoryImageRepository::class)]
#[Uploadable]
class HistoryImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['content:list', 'content:item'])]
    private ?int $id = null;


    #[UploadableField(mapping: 'images', fileNameProperty: 'name', size: 'size')]
    private ?File $file = null;


    #[ORM\Column(length: 255)]
    #[Groups(['content:list', 'content:item'])]
    private ?string $name = null;


    #[ORM\Column]
    private ?int $size = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    #[ORM\ManyToOne(targetEntity: History::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?History $historyContent = null;


                    /*-------------------------------------------*
                     *          Entity field accessors.          *
                     *-------------------------------------------*/
    public function getId(): ?int
    {
        return $this->id;
    }


    public function setFile(?File $file): self
    {
        $this->file = $file;

        if (null !== $file) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }
    public function getFile(): ?File
    {
        return $this->file;
    }


    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function getSize(): ?int
    {
        return $this->size;
    }
    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
    }


    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    public function getHistoryContent(): ?History
    {
        return $this->historyContent;
    }
    public function setHistoryContent(?History $historyContent): static
    {
        $this->historyContent = $historyContent;

        return $this;
    }


    public function __toString(): string
    {
        return $this->getName();
    }
}
