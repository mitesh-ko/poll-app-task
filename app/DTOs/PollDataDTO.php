<?php
namespace App\DTOs;

readonly class PollDataDTO
{
    public function __construct(
        public int $winnerOption,
        public int $totalAns,
    ) {}

    public static function storePollMeta($details): self
    {
        return new self(
            winnerOption: $details['option_id'],
            totalAns: $details['ans_count'],
        );
    }
}
