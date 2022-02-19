<?php

namespace App\Entity;

use App\Repository\UnderActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UnderActivityRepository::class)
 */
class UnderActivity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Company::class, mappedBy="underActivities")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=CompanyActivity::class, inversedBy="underActivities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity;

    public function __construct()
    {
        $this->company = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompany(): Collection
    {
        return $this->company;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->company->contains($company)) {
            $this->company[] = $company;
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        $this->company->removeElement($company);

        return $this;
    }

    public function getActivity(): ?CompanyActivity
    {
        return $this->activity;
    }

    public function setActivity(?CompanyActivity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }
}
