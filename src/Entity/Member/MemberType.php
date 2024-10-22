<?php

namespace App\Entity\Member;

use ApiPlatform\Metadata\ApiProperty;
use App\Repository\Member\MemberTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: MemberTypeRepository::class)]
class MemberType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['member:list', 'member:item'])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['member:list', 'member:item'])]
    private ?string $name = null;


    #[ORM\Column(length: 255)]
    #[Groups(['member:list', 'member:item'])]
    #[ApiProperty(identifier: true)]
    private ?string $apiResource = null;


                    /*-------------------------------------------*
                     *          Entity field accessors.          *
                     *-------------------------------------------*/
    public function getId(): ?int
    {
        return $this->id;
    }


    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
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
        return $this->name;
    }
}
