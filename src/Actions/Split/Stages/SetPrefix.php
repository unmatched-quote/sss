<?php

namespace JustSomeCode\ShamirSecretSharing\Actions\Split\Stages;

use JustSomeCode\ShamirSecretSharing\Constants;
use JustSomeCode\ShamirSecretSharing\Actions\Split\SplitState;
use function JustSomeCode\ShamirSecretSharing\convert_base;

class SetPrefix
{
    public function handle(SplitState $state): SplitState
    {
        $prefix = sprintf(
            $state->getPrefixFormat(),
            $state->share->encryption_bytes,
            convert_base($state->share->threshold, Constants::DECIMAL, Constants::ALPHABET)
        );

        $state->setPrefix($prefix);

        return $state;
    }
}