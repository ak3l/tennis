<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class TwigApiIdExtension
 */
class TwigApiIdExtension extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFilters() : array
    {
        return [
            new TwigFilter('apiId', [$this, 'apiIdFilter']),
        ];
    }

    /**
     * @param string $apiId
     *
     * @return string
     */
    public function apiIdFilter(string $apiId) : string
    {
        $apiArray = explode(':', $apiId);

        return end($apiArray);
    }
}
