<?php

namespace App\Entity\Member\MemberMediaType;

use App\Entity\Member\Member;
use App\Repository\Member\MemberVideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;


#[ORM\Entity(repositoryClass: MemberVideoRepository::class)]
#[Uploadable]
class MemberVideo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['member:list', 'member:item'])]
    private ?int $id = null;

    #[UploadableField(mapping: 'member_videos', fileNameProperty: 'name', size: 'size')]
    private ?File $file = null;


    #[ORM\Column(length: 255)]
    #[Groups(['member:list', 'member:item'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['member:list', 'member:item'])]
    private ?int $size = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['member:list', 'member:item'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Member $member = null;


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

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
