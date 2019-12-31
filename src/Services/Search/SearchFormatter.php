<?php

namespace App\Services\Search;

use App\Repository\PlayerRepository;

/**
 * Class SearchFormatter
 */
class SearchFormatter
{
    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * SearchFormatter constructor.
     *
     * @param PlayerRepository $playerRepository
     */
    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @param string $string
     *
     * @return array
     */
    public function formatSearch(string $string) : array
    {
        $searchArray = explode(' ', $string);
        foreach ($searchArray as $key => $word) {
            if (2 > strlen($word)) {
                unset($searchArray[$key]);
            }
        }

        return($searchArray);
    }

    /**
     * @param array $searchArray
     *
     * @return array
     */
    public function getSearchedPlayers(array $searchArray): array
    {
        $foundPlayers = [];
        foreach ($searchArray as $name) {
            $players = $this->playerRepository->searchPlayersByName($name);
            $foundPlayers = array_merge($foundPlayers, $players);
        }
        $foundPlayers = array_unique($foundPlayers, SORT_REGULAR);

        return $foundPlayers;
    }
}
