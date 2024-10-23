<?php

namespace App\Entity\Member;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Entity\Member\MemberMediaType\MemberAudio;
use App\Entity\Member\MemberMediaType\MemberImage;
use App\Entity\Member\MemberMediaType\MemberPoetry;
use App\Entity\Member\MemberMediaType\MemberVideo;
use App\Entity\Traits\TimeStampableTrait;
use App\Repository\Member\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    shortName: 'Member',
    operations: [
        new Get(normalizationContext: ['groups' => 'member:item']),
        new GetCollection(normalizationContext: ['groups' => 'member:list']),

        new GetCollection(
            uriTemplate: 'member/{type}',
            uriVariables: [
                'type' => new Link(
                    identifiers: ['apiResource'],
                    fromClass: MemberType::class,
                    toProperty: 'type',
                    description: 'Type of member: [\'heroes\', \'harovchane\']'
                )
            ],
            normalizationContext: ['groups' => 'member:list'],
        ),
    ],
    paginationEnabled: false,
)]
class Member
{
    use TimeStampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['member:list', 'member:item'])]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity: MemberType::class)]
    #[Groups(['member:list', 'member:item'])]
    private ?MemberType $type = null;


    #[ORM\Column(length: 255)]
    #[Groups(['member:list', 'member:item'])]
    private ?string $firstName = null;


    #[ORM\Column(length: 255)]
    #[Groups(['member:list', 'member:item'])]
    private ?string $lastName = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['member:list', 'member:item'])]
    private ?string $patronymic = null;


    #[ORM\Column(length: 1275)]
    #[Groups(['member:list', 'member:item'])]
    private ?string $bio = null;


    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['member:list', 'member:item'])]
    private ?\DateTimeInterface $birthDate = null;


    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['member:list', 'member:item'])]
    private ?\DateTimeInterface $deathDate = null;


    #[ORM\OneToMany(targetEntity: MemberImage::class,  mappedBy: 'member', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['member:list', 'member:item'])]
    private Collection $images;


    #[ORM\OneToMany(targetEntity: MemberAudio::class,  mappedBy: 'member', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['member:list', 'member:item'])]
    private Collection $audios;


    #[ORM\OneToMany(targetEntity: MemberVideo::class,  mappedBy: 'member', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['member:list', 'member:item'])]
    private Collection $videos;


    #[ORM\OneToMany(targetEntity: MemberPoetry::class, mappedBy: 'member', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['member:list', 'member:item'])]
    private Collection $poetries;


                    /*-------------------------------------------*
                     *          Entity field accessors.          *
                     *-------------------------------------------*/
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->audios = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->poetries = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function setType(?MemberType $type): static
    {
        $this->type = $type;

        return $this;
    }
    public function getType(): ?MemberType
    {
        return $this->type;
    }


    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }


    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }


    public function setPatronymic(?string $patronymic): static
    {
        $this->patronymic = $patronymic;

        return $this;
    }
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }


    public function setBio(string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }
    public function getBio(): ?string
    {
        return $this->bio;
    }


    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }
    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }


    public function setDeathDate(?\DateTimeInterface $deathDate): static
    {
        $this->deathDate = $deathDate;

        return $this;
    }
    public function getDeathDate(): ?\DateTimeInterface
    {
        return $this->deathDate;
    }


                /*------------------------------------------------*
                 *          Entity Media Type accessors.          *
                 *------------------------------------------------*/
    public function getImages(): Collection
    {
        return $this->images;
    }
    public function addImage(MemberImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setMember($this);
        }

        return $this;
    }
    public function removeImage(MemberImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getMember() === $this) {
                $image->setMember(null);
            }
        }

        return $this;
    }


    public function getVideos(): Collection
    {
        return $this->videos;
    }
    public function addVideo(MemberVideo $video): static
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setMember($this);
        }

        return $this;
    }
    public function removeVideo(MemberVideo $video): static
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getMember() === $this) {
                $video->setMember(null);
            }
        }

        return $this;
    }


    public function getAudios(): Collection
    {
        return $this->audios;
    }
    public function addAudio(MemberAudio $audio): static
    {
        if (!$this->audios->contains($audio)) {
            $this->audios->add($audio);
            $audio->setMember($this);
        }

        return $this;
    }
    public function removeAudio(MemberAudio $audio): static
    {
        if ($this->audios->removeElement($audio)) {
            // set the owning side to null (unless already changed)
            if ($audio->getMember() === $this) {
                $audio->setMember(null);
            }
        }

        return $this;
    }


    public function getPoetries(): Collection
    {
        return $this->poetries;
    }
    public function addPoetry(MemberPoetry $poetry): static
    {
        if (!$this->poetries->contains($poetry)) {
            $this->poetries->add($poetry);
            $poetry->setMember($this);
        }

        return $this;
    }
    public function removePoetry(MemberPoetry $poetry): static
    {
        if ($this->poetries->removeElement($poetry)) {
            // set the owning side to null (unless already changed)
            if ($poetry->getMember() === $this) {
                $poetry->setMember(null);
            }
        }

        return $this;
    }


                     /*---------------------------------*
                      *           Crud actions          *
                      *---------------------------------*/
    public function toString(): string
    {
        return $this->type.' '.$this->firstName . ' ' . $this->lastName.' '.$this->patronymic;
    }
}
