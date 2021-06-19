<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
    private $CompanyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ContactName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ContactEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ContactPhone;

    /**
     * @ORM\OneToMany(targetEntity=Website::class, mappedBy="Client")
     */
    private $Websites;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->Websites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }

    public function setCompanyName(string $CompanyName): self
    {
        $this->CompanyName = $CompanyName;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->ContactName;
    }

    public function setContactName(string $ContactName): self
    {
        $this->ContactName = $ContactName;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->ContactEmail;
    }

    public function setContactEmail(?string $ContactEmail): self
    {
        $this->ContactEmail = $ContactEmail;

        return $this;
    }

    public function getContactPhone(): ?string
    {
        return $this->ContactPhone;
    }

    public function setContactPhone(?string $ContactPhone): self
    {
        $this->ContactPhone = $ContactPhone;

        return $this;
    }

    /**
     * @return Collection|Website[]
     */
    public function getWebsites(): Collection
    {
        return $this->Websites;
    }

    public function addWebsite(Website $website): self
    {
        if (!$this->Websites->contains($website)) {
            $this->Websites[] = $website;
            $website->setClient($this);
        }

        return $this;
    }

    public function removeWebsite(Website $website): self
    {
        if ($this->Websites->removeElement($website)) {
            // set the owning side to null (unless already changed)
            if ($website->getClient() === $this) {
                $website->setClient(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
