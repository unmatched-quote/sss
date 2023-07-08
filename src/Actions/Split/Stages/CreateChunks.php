<?php

namespace JustSomeCode\ShamirSecretSharing\Actions\Split\Stages;

use PHPUnit\TextUI\Configuration\Constant;
use JustSomeCode\ShamirSecretSharing\Constants;
use JustSomeCode\ShamirSecretSharing\Actions\Split\SplitState;
use function JustSomeCode\ShamirSecretSharing\convert_base;

class CreateChunks
{
    public function handle(SplitState $state): SplitState
    {
        $collection = [];

        $result = $state->getYPolynomialValues();

        $secret_length = strlen($state->share->secret);

        // calculate how many bytes, we need to cut off during recovery
        $tail = match($secret_length % $state->share->encryption_bytes > 0) {
            true => fn() => str_repeat(Constants::PADDING,$state->share->encryption_bytes - $secret_length % $state->share->encryption_bytes),
            default => ''
        };

        $chunks = ceil($secret_length / $state->share->encryption_bytes);

        for($i = 0; $i < $state->share->shares; ++$i)
        {
            $key = sprintf(
                $state->getPrefix() . '%' . $state->getPrefixChar() . $state->getMaxKeyLength() . 's',
                convert_base(($i + 1), Constants::DECIMAL, Constants::ALPHABET)
            );

            for($j = 0; $j < $chunks; ++$j)
            {
                $key .= str_pad(
                    convert_base($result[$j * $state->share->shares + $i], Constants::DECIMAL, Constants::ALPHABET),
                    $state->getMaxKeyLength(),
                    $state->getPrefixChar(),
                    STR_PAD_LEFT
                );
            }

            $collection[] = $key . $tail;
        }

        $state->setShareCollection($collection);

        return $state;
    }
}