<?php

namespace App\Entity;

use App\Repository\InstructorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstructorRepository::class)]
class Instructor
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

    #[ORM\OneToMany(mappedBy: 'instructor', targetEntity: DrivingSessionBooking::class)]
    private Collection $lessonReservations;

    public function __construct()
    {
        $this->lessonReservations = new ArrayCollection();
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

    /**
     * @return Collection<int, DrivingSessionBooking>
     */
    public function getLessonReservations(): Collection
    {
        return $this->lessonReservations;
    }

    public function addLessonReservation(DrivingSessionBooking $lessonReservation): static
    {
        if (!$this->lessonReservations->contains($lessonReservation)) {
            $this->lessonReservations->add($lessonReservation);
            $lessonReservation->setInstructor($this);
        }

        return $this;
    }

    public function removeLessonReservation(DrivingSessionBooking $lessonReservation): static
    {
        if ($this->lessonReservations->removeElement($lessonReservation)) {
            // set the owning side to null (unless already changed)
            if ($lessonReservation->getInstructor() === $this) {
                $lessonReservation->setInstructor(null);
            }
        }

        return $this;
    }
}
