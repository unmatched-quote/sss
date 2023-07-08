<?php

namespace JustSomeCode\ShamirSecretSharing\DTO;

final readonly class RecoverKey
{
    public function __construct(
        public string $key
    ){}
}