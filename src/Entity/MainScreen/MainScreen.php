<?php

namespace App\Entity\MainScreen;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MainScreen\MainScreenRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: MainScreenRepository::class)]
#[ApiResource(
    shortName: 'MainScreen',
    operations: [
        new Get(normalizationContext: ['groups' => 'button:item']),
        new GetCollection(normalizationContext: ['groups' => 'button:list']),
    ],
    paginationEnabled: false,
)]
class MainScreen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['button:list', 'button:item'])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['button:list', 'button:item'])]
    private ?string $value1 = null;


    #[ORM\Column(length: 255)]
    #[Groups(['button:list', 'button:item'])]
    private ?string $value2 = null;


    #[ORM\Column(length: 255)]
    #[Groups(['button:list', 'button:item'])]
    private ?string $value3 = null;



    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }


    public function getValue1(): ?string
    {
        return $this->value1;
    }
    public function setValue1(?string $value1): self
    {
        $this->value1 = $value1;
        return $this;
    }


    public function getValue2(): ?string
    {
        return $this->value2;
    }
    public function setValue2(?string $value2): self
    {
        $this->value2 = $value2;
        return $this;
    }


    public function getValue3(): ?string
    {
        return $this->value3;
    }
    public function setValue3(?string $value3): self
    {
        $this->value3 = $value3;
        return $this;
    }
}