<?php

namespace App\Message;

final readonly class UpdateVideoGamePrice
{
    public function __construct(public int $videoGameId)
    {
    }
}
