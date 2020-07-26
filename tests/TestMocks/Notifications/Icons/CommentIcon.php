<?php


namespace Piscibus\Notifly\Tests\TestMocks\Notifications\Icons;

use Piscibus\Notifly\Notifications\Icon;

/**
 * Class CommentIcon
 * @package Piscibus\Notifly\Tests\TestMocks\Notifications\Icons
 */
class CommentIcon extends Icon
{
    public function toArray(): array
    {
        return [
            'width' => $this->object->getId(),
        ];
    }
}
