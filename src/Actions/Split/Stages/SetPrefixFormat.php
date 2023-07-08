<?php

namespace JustSomeCode\ShamirSecretSharing\Actions\Split\Stages;

use JustSomeCode\ShamirSecretSharing\Actions\Split\SplitState;

class SetPrefixFormat
{
    public function handle(SplitState $state): SplitState
    {
        $state->setPrefixFormat(
            '%x%' . $state->getPrefixChar() . $state->getMaxKeyLength() .'s'
        );

        return $state;
    }
}