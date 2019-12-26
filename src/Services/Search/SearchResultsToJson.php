<?php

namespace App\Services\Search;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Class SearchResultsToJson
 */
class SearchResultsToJson
{
    /**
     * @param array $searchResults
     *
     * @return bool|false|float|int|string
     */
    public function searchResultsToJson(array $searchResults)
    {
        $resultArray = [];
        foreach ($searchResults as $result) {
            $array = [
                'id'   => $result->getApiIdInt(),
                'slug' => $result->getSlug(),
                'name' => $result->getName(),
            ];
            array_push($resultArray, $array);
        }
        $encoder = new JsonEncoder();

        return $encoder->encode($resultArray, 'json');
    }
}