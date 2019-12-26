<?php

namespace App\Services\Search;

use App\Repository\PlayerRepository;

/**
 * Class SearchFormatter
 */
class SearchFormatter
{
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
     * @param array            $searchArray
     * @param PlayerRepository $repository
     *
     * @return array
     */
    public function getSearchedPlayers(array $searchArray, PlayerRepository $repository): array
    {
        $foundPlayers = [];
        foreach ($searchArray as $name) {
            $players = $repository->searchPlayersByName($name);
            $foundPlayers = array_merge($foundPlayers, $players);
        }
        $foundPlayers = array_unique($foundPlayers, SORT_REGULAR);

        return $foundPlayers;
    }
}
