<?php

namespace App\Entity\User;

use App\Repository\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 180)]
    private ?string $username = null;


    #[ORM\Column]
    private array $roles = [];


    #[ORM\Column]
    private ?string $password = null;


                    /*-------------------------------------------*
                     *          Entity field accessors.          *
                     *-------------------------------------------*/
    public function getId(): ?int
    {
        return $this->id;
    }


    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }


    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }


    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
