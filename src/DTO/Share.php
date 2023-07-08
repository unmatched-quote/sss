<?php

namespace JustSomeCode\ShamirSecretSharing\DTO;

use JustSomeCode\ShamirSecretSharing\Constants;
use function JustSomeCode\ShamirSecretSharing\get_num_byes_for_encryption;

final readonly class Share
{
    public int $encryption_bytes;
    public int $prime;

    public function __construct(
        #[\SensitiveParameter(\Attribute::TARGET_PROPERTY)] public string $secret,
        public int $shares,
        public int $threshold
    )
    {
        // Bail early if someone tried to be smart and mess the algorithm up
        if($this->shares < $this->threshold)
        {
            throw new \OutOfRangeException('Threshold cannot be larger than number of shares.');
        }

        // Get the encryption bytes and prime for the given number of shares
        $size = get_num_byes_for_encryption($this->shares);

        $prime = Constants::CHUNK_TO_PRIME[$size] ?? null;

        if(empty($prime)) throw new \OutOfBoundsException('Invalid number of shares provided.');

        $this->encryption_bytes = $size;
        $this->prime = $prime;
    }
}