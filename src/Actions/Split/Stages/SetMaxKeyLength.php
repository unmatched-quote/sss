<?php

namespace JustSomeCode\ShamirSecretSharing\Actions\Split\Stages;

use JustSomeCode\ShamirSecretSharing\Actions\Split\SplitState;
use function JustSomeCode\ShamirSecretSharing\get_max_key_length;

class SetMaxKeyLength
{
    public function handle(SplitState $state): SplitState
    {
        $state->setMaxKeyLength(
            get_max_key_length($state->share->encryption_bytes)
        );

        return $state;
    }
}