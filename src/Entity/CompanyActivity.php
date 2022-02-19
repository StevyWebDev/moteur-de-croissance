<?php

namespace App\Entity;

use App\Repository\CompanyActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyActivityRepository::class)
 */
class CompanyActivity
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
     * @ORM\ManyToMany(targetEntity=Company::class, mappedBy="companyActivities")
     */
    private $compagny;

    /**
     * @ORM\OneToMany(targetEntity=UnderActivity::class, mappedBy="activity", orphanRemoval=true)
     */
    private $underActivities;

    public function __construct()
    {
        $this->compagny = new ArrayCollection();
        $this->underActivities = new ArrayCollection();
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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|Company[]
     */
    public function getCompagny(): Collection
    {
        return $this->compagny;
    }

    public function addCompagny(Company $compagny): self
    {
        if (!$this->compagny->contains($compagny)) {
            $this->compagny[] = $compagny;
        }

        return $this;
    }

    public function removeCompagny(Company $compagny): self
    {
        $this->compagny->removeElement($compagny);

        return $this;
    }

    /**
     * @return Collection|UnderActivity[]
     */
    public function getUnderActivities(): Collection
    {
        return $this->underActivities;
    }

    public function addUnderActivity(UnderActivity $underActivity): self
    {
        if (!$this->underActivities->contains($underActivity)) {
            $this->underActivities[] = $underActivity;
            $underActivity->setActivity($this);
        }

        return $this;
    }

    public function removeUnderActivity(UnderActivity $underActivity): self
    {
        if ($this->underActivities->removeElement($underActivity)) {
            // set the owning side to null (unless already changed)
            if ($underActivity->getActivity() === $this) {
                $underActivity->setActivity(null);
            }
        }

        return $this;
    }
}
