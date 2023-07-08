<?php

namespace JustSomeCode\ShamirSecretSharing\Tests\Unit;

use PHPUnit\Framework\TestCase;
use function JustSomeCode\ShamirSecretSharing\share;
use function JustSomeCode\ShamirSecretSharing\unpack_str_bin_to_dec;

class FunctionsTest extends TestCase
{
    public function test_share()
    {
        $secret = '1234fksjaj32u5898u9230983932890352890358903';

        $result = share($secret, 5, 3);

        $this->assertIsArray($result);
    }
}