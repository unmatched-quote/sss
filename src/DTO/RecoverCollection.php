<?php

namespace JustSomeCode\ShamirSecretSharing\DTO;

final readonly class RecoverCollection
{
    public array $keyCollection;

    public function __construct(array $keys)
    {
        foreach($keys as $key)
        {
            if(!$key instanceof RecoverKey)
            {
                throw new \InvalidArgumentException('Invalid value. Expected RecoveryKey, got: '. gettype($key));
            }

            $this->keyCollection[] = $key;
        }
    }
}