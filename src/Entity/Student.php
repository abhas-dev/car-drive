<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $registeredAt = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: DrivingSessionBooking::class)]
    private Collection $drivingSessionBookings;

    public function __construct()
    {
        $this->drivingSessionBookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeImmutable $registeredAt): static
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    /**
     * @return Collection<int, DrivingSessionBooking>
     */
    public function getDrivingSessionBookings(): Collection
    {
        return $this->drivingSessionBookings;
    }

    public function addDrivingSessionBooking(DrivingSessionBooking $drivingSessionBooking): static
    {
        if (!$this->drivingSessionBookings->contains($drivingSessionBooking)) {
            $this->drivingSessionBookings->add($drivingSessionBooking);
            $drivingSessionBooking->setStudent($this);
        }

        return $this;
    }

    public function removeDrivingSessionBooking(DrivingSessionBooking $drivingSessionBooking): static
    {
        if ($this->drivingSessionBookings->removeElement($drivingSessionBooking)) {
            // set the owning side to null (unless already changed)
            if ($drivingSessionBooking->getStudent() === $this) {
                $drivingSessionBooking->setStudent(null);
            }
        }

        return $this;
    }
}
