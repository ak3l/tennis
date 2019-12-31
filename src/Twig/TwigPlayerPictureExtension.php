<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class TwigPlayerPictureExtension
 */
class TwigPlayerPictureExtension extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFilters() : array
    {
        return [
            new TwigFilter('playerPicture', [$this, 'playerPictureFilter']),
        ];
    }

    /**
     * @param string $playerAbbreviation
     *
     * @return string
     */
    public function playerPictureFilter(string $playerAbbreviation) : string
    {
        if (file_exists('../public/build/players/'.$playerAbbreviation.'.jpg')) {
            return $playerAbbreviation;
        }

        return 'playerPlaceholder';
    }
}
