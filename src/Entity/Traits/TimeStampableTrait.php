<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;


trait TimeStampableTrait
{
    #[ORM\Column(type: "datetime", nullable: true)]
    private ?DateTimeInterface $createdAt;


    #[ORM\Column(type: "datetime", nullable: true)]
    private ?DateTimeInterface $updatedAt;


    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt ?? new DateTime();
    }
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt ?? new DateTime();
    }
    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $now = new DateTime();
        $this->setUpdatedAt($now);
        if ($this->getId() === null) {
            $this->setCreatedAt($now);
        }
    }
}