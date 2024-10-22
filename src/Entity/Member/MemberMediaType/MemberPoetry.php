<?php

namespace App\Entity\Member\MemberMediaType;

use App\Entity\Member\Member;
use App\Repository\Member\MemberPoetryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: MemberPoetryRepository::class)]
class MemberPoetry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['member:list', 'member:item'])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['member:list', 'member:item'])]
    private ?string $title = null;


    #[ORM\Column(length: 255)]
    #[Groups(['member:list', 'member:item'])]
    private ?string $description = null;


    #[ORM\Column(length: 255)]
    #[Groups(['member:list', 'member:item'])]
    private ?string $text = null;


    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'poetries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;


                    /*-------------------------------------------*
                     *          Entity field accessors.          *
                     *-------------------------------------------*/
    public function getId(): ?int
    {
        return $this->id;
    }


    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }


    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }


    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }
    public function getText(): ?string
    {
        return $this->text;
    }


    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }
    public function getMember(): ?Member
    {
        return $this->member;
    }


    public function __toString(): string
    {
        return $this->getTitle();
    }
}
