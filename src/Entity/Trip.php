<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: vehicle::class, inversedBy: 'trips')]
    private Collection $vehicle;

    #[ORM\OneToMany(targetEntity: driver::class, mappedBy: 'trip')]
    private Collection $driver;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function __construct()
    {
        $this->vehicle = new ArrayCollection();
        $this->driver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, vehicle>
     */
    public function getVehicle(): Collection
    {
        return $this->vehicle;
    }

    public function addVehicle(vehicle $vehicle): static
    {
        if (!$this->vehicle->contains($vehicle)) {
            $this->vehicle->add($vehicle);
        }

        return $this;
    }

    public function removeVehicle(vehicle $vehicle): static
    {
        $this->vehicle->removeElement($vehicle);

        return $this;
    }

    /**
     * @return Collection<int, driver>
     */
    public function getDriver(): Collection
    {
        return $this->driver;
    }

    public function addDriver(driver $driver): static
    {
        if (!$this->driver->contains($driver)) {
            $this->driver->add($driver);
            $driver->setTrip($this);
        }

        return $this;
    }

    public function removeDriver(driver $driver): static
    {
        if ($this->driver->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getTrip() === $this) {
                $driver->setTrip(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
