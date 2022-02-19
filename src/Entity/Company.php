<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
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
     * @ORM\Column(type="integer")
     */
    private $siren_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number_tva;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_postal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number_naf;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="companies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=CompanyActivity::class, inversedBy="compagny")
     */
    private $companyActivities;

    /**
     * @ORM\ManyToMany(targetEntity=UnderActivity::class, inversedBy="company")
     */
    private $underActivities;

    /**
     * @ORM\Column(type="float", scale=4, precision=6)
     */
    private $lat;

    /**
     * @ORM\Column(type="float", scale=4, precision=7)
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity=CompanyNotice::class, mappedBy="company", orphanRemoval=true)
     */
    private $companyNotices;

    public function __construct()
    {
        $this->companyActivities = new ArrayCollection();
        $this->underActivities = new ArrayCollection();
        $this->companyNotices = new ArrayCollection();
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

    public function getSirenNumber(): ?int
    {
        return $this->siren_number;
    }

    public function setSirenNumber(int $siren_number): self
    {
        $this->siren_number = $siren_number;

        return $this;
    }

    public function getNumberTva(): ?string
    {
        return $this->number_tva;
    }

    public function setNumberTva(string $number_tva): self
    {
        $this->number_tva = $number_tva;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getNumberPostal(): ?int
    {
        return $this->number_postal;
    }

    public function setNumberPostal(int $number_postal): self
    {
        $this->number_postal = $number_postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getNumberNaf(): ?string
    {
        return $this->number_naf;
    }

    public function setNumberNaf(string $number_naf): self
    {
        $this->number_naf = $number_naf;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|CompanyActivity[]
     */
    public function getCompanyActivities(): Collection
    {
        return $this->companyActivities;
    }

    public function addCompanyActivity(CompanyActivity $companyActivity): self
    {
        if (!$this->companyActivities->contains($companyActivity)) {
            $this->companyActivities[] = $companyActivity;
            $companyActivity->addCompagny($this);
        }

        return $this;
    }

    public function removeCompanyActivity(CompanyActivity $companyActivity): self
    {
        if ($this->companyActivities->removeElement($companyActivity)) {
            $companyActivity->removeCompagny($this);
        }

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
            $underActivity->addCompany($this);
        }

        return $this;
    }

    public function removeUnderActivity(UnderActivity $underActivity): self
    {
        if ($this->underActivities->removeElement($underActivity)) {
            $underActivity->removeCompany($this);
        }

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection|CompanyNotice[]
     */
    public function getCompanyNotices(): Collection
    {
        return $this->companyNotices;
    }

    public function addCompanyNotice(CompanyNotice $companyNotice): self
    {
        if (!$this->companyNotices->contains($companyNotice)) {
            $this->companyNotices[] = $companyNotice;
            $companyNotice->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyNotice(CompanyNotice $companyNotice): self
    {
        if ($this->companyNotices->removeElement($companyNotice)) {
            // set the owning side to null (unless already changed)
            if ($companyNotice->getCompany() === $this) {
                $companyNotice->setCompany(null);
            }
        }

        return $this;
    }
}
