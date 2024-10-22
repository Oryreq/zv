<?php

namespace App\Entity\History;

use ApiPlatform\Metadata\ApiProperty;
use App\Repository\History\ContentTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: ContentTypeRepository::class)]
class ContentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['content:list', 'content:item'])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['content:list', 'content:item'])]
    private ?string $value = null;


    #[ORM\Column(length: 255)]
    #[Groups(['content:list', 'content:item'])]
    #[ApiProperty(identifier: true)]
    private ?string $apiResource = null;


                    /*-------------------------------------------*
                     *          Entity field accessors.          *
                     *-------------------------------------------*/
    public function getId(): ?int
    {
        return $this->id;
    }


    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }
    public function getValue(): ?string
    {
        return $this->value;
    }


    public function setApiResource(?string $apiResource): void
    {
        $this->apiResource = $apiResource;
    }
    public function getApiResource(): ?string
    {
        return $this->apiResource;
    }


    public function __toString(): string
    {
        return $this->value;
    }
}
