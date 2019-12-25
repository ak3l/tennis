<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Player
 *
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $nationality;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $abbreviation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $proYear;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $handedness;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weight;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $highestSinglesRanking;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $highestSinglesRankingDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $apiId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var PlayerSinglesRanking
     *
     * @ORM\OneToOne(targetEntity="App\Entity\PlayerSinglesRanking", inversedBy="player", cascade={"persist", "remove"})
     */
    private $singlesRanking;

    /**
     * @var PlayerDoublesRanking
     *
     * @ORM\OneToOne(targetEntity="App\Entity\PlayerDoublesRanking", inversedBy="player", cascade={"persist", "remove"})
     */
    private $doublesRanking;

    /**
     * @var PlayerStatistics
     *
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerStatistics", mappedBy="player", orphanRemoval=true)
     */
    private $statistics;

    public function __construct()
    {
        $this->statistics = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getSlug() : ?string
    {
        return (new Slugify())->slugify($this->getName());
    }

    /**
     * @param string $name
     *
     * @return Player
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     *
     * @return Player
     */
    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     *
     * @return Player
     */
    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     *
     * @return Player
     */
    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return Player
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTimeInterface|null $birthDate
     *
     * @return Player
     */
    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProYear(): ?string
    {
        return $this->proYear;
    }

    /**
     * @param string|null $proYear
     *
     * @return Player
     */
    public function setProYear(?string $proYear): self
    {
        $this->proYear = $proYear;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHandedness(): ?string
    {
        return $this->handedness;
    }

    /**
     * @param string|null $handedness
     *
     * @return Player
     */
    public function setHandedness(?string $handedness): self
    {
        $this->handedness = $handedness;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     *
     * @return Player
     */
    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @param int|null $weight
     *
     * @return Player
     */
    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHighestSinglesRanking(): ?int
    {
        return $this->highestSinglesRanking;
    }

    /**
     * @param int|null $highestSinglesRanking
     *
     * @return Player
     */
    public function setHighestSinglesRanking(?int $highestSinglesRanking): self
    {
        $this->highestSinglesRanking = $highestSinglesRanking;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getHighestSinglesRankingDate(): ?\DateTimeInterface
    {
        return $this->highestSinglesRankingDate;
    }

    /**
     * @param \DateTimeInterface|null $highestSinglesRankingDate
     *
     * @return Player
     */
    public function setHighestSinglesRankingDate(?\DateTimeInterface $highestSinglesRankingDate): self
    {
        $this->highestSinglesRankingDate = $highestSinglesRankingDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getApiId(): ?string
    {
        return $this->apiId;
    }

    /**
     * @return int|null
     */
    public function getApiIdInt() : ?int
    {
        $apiArray = explode(':', $this->getApiId());

        return end($apiArray);
    }

    /**
     * @param string $apiId
     *
     * @return Player
     */
    public function setApiId(string $apiId): self
    {
        $this->apiId = $apiId;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface $updatedAt
     *
     * @return Player
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return PlayerSinglesRanking|null
     */
    public function getSinglesRanking(): ?PlayerSinglesRanking
    {
        return $this->singlesRanking;
    }

    /**
     * @param PlayerSinglesRanking $singlesRanking
     *
     * @return Player
     */
    public function setSinglesRanking(PlayerSinglesRanking $singlesRanking): self
    {
        $this->singlesRanking = $singlesRanking;

        return $this;
    }

    /**
     * @return PlayerDoublesRanking|null
     */
    public function getDoublesRanking(): ?PlayerDoublesRanking
    {
        return $this->doublesRanking;
    }

    /**
     * @param PlayerDoublesRanking|null $doublesRanking
     *
     * @return Player
     */
    public function setDoublesRanking(?PlayerDoublesRanking $doublesRanking): self
    {
        $this->doublesRanking = $doublesRanking;

        return $this;
    }

    /**
     * @return Collection|PlayerStatistics[]
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    /**
     * @param PlayerStatistics $statistic
     *
     * @return Player
     */
    public function addStatistic(PlayerStatistics $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->setPlayer($this);
        }

        return $this;
    }

    /**
     * @param PlayerStatistics $statistic
     *
     * @return Player
     */
    public function removeStatistic(PlayerStatistics $statistic): self
    {
        if ($this->statistics->contains($statistic)) {
            $this->statistics->removeElement($statistic);
            // set the owning side to null (unless already changed)
            if ($statistic->getPlayer() === $this) {
                $statistic->setPlayer(null);
            }
        }

        return $this;
    }
}
