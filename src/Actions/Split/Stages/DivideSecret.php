<?php

namespace JustSomeCode\ShamirSecretSharing\Actions\Split\Stages;

use JustSomeCode\ShamirSecretSharing\Actions\Split\SplitState;
use function JustSomeCode\ShamirSecretSharing\horner_method;
use function JustSomeCode\ShamirSecretSharing\unpack_str_bin_to_dec;
use function JustSomeCode\ShamirSecretSharing\generate_polynomial_coefficients;

class DivideSecret
{
    public function handle(SplitState $state): SplitState
    {
        $result = [];

        $byte_array = unpack_str_bin_to_dec($state->share->secret);

        foreach($byte_array as $byte)
        {
            $coefficients = generate_polynomial_coefficients($state->share->threshold, $state->share->prime);

            $coefficients[] = $byte;

            for($i = 1; $i <= $state->share->shares; $i++)
            {
                $result[] = horner_method($i, $coefficients, $state->share->prime);
            }
        }

        $state->setYPolynomialValues($result);

        return $state;
    }
}