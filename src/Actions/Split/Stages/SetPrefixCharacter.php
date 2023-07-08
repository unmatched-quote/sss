<?php

namespace JustSomeCode\ShamirSecretSharing\Actions\Split\Stages;

use JustSomeCode\ShamirSecretSharing\Constants;
use JustSomeCode\ShamirSecretSharing\Actions\Split\SplitState;

class SetPrefixCharacter
{
    public function handle(SplitState $state): SplitState
    {
        $state->setPrefixChar(
            substr(Constants::ALPHABET, 0, 1)
        );

        return $state;
    }
}