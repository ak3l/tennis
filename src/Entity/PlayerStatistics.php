<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerStatisticsRepository")
 */
class PlayerStatistics
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $surface;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $tournamentPlayed = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $tournamentWon = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $matchesPlayed = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $matchesWon = 0;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="statistics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int $year
     *
     * @return PlayerStatistics
     */
    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSurface(): ?string
    {
        return $this->surface;
    }

    /**
     * @param string $surface
     *
     * @return PlayerStatistics
     */
    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTournamentPlayed(): ?int
    {
        return $this->tournamentPlayed;
    }

    /**
     * @param int $tournamentPlayed
     *
     * @return PlayerStatistics
     */
    public function setTournamentPlayed(int $tournamentPlayed): self
    {
        $this->tournamentPlayed = $tournamentPlayed;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTournamentWon(): ?int
    {
        return $this->tournamentWon;
    }

    /**
     * @param int $tournamentWon
     *
     * @return PlayerStatistics
     */
    public function setTournamentWon(int $tournamentWon): self
    {
        $this->tournamentWon = $tournamentWon;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMatchesPlayed(): ?int
    {
        return $this->matchesPlayed;
    }

    /**
     * @param int $matchesPlayed
     *
     * @return PlayerStatistics
     */
    public function setMatchesPlayed(int $matchesPlayed): self
    {
        $this->matchesPlayed = $matchesPlayed;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMatchesWon(): ?int
    {
        return $this->matchesWon;
    }

    /**
     * @param int $matchesWon
     *
     * @return PlayerStatistics
     */
    public function setMatchesWon(int $matchesWon): self
    {
        $this->matchesWon = $matchesWon;

        return $this;
    }

    /**
     * @return Player|null
     */
    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    /**
     * @param Player|null $player
     *
     * @return PlayerStatistics
     */
    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
