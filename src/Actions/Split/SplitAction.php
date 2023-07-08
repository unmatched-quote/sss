<?php

namespace JustSomeCode\ShamirSecretSharing\Actions\Split;

use JustSomeCode\ShamirSecretSharing\Pipeline;
use JustSomeCode\ShamirSecretSharing\DTO\Share;
use JustSomeCode\ShamirSecretSharing\Actions\Split\Stages\SetPrefix;
use JustSomeCode\ShamirSecretSharing\Actions\Split\Stages\DivideSecret;
use JustSomeCode\ShamirSecretSharing\Actions\Split\Stages\CreateChunks;
use JustSomeCode\ShamirSecretSharing\Actions\Split\Stages\SetMaxKeyLength;
use JustSomeCode\ShamirSecretSharing\Actions\Split\Stages\SetPrefixFormat;
use JustSomeCode\ShamirSecretSharing\Actions\Split\Stages\SetPrefixCharacter;

class SplitAction
{
    protected array $result;

    public function execute(Share $share): self
    {
        $state = new SplitState($share);

        $pipeline = new Pipeline();

        $this->result = $pipeline
            ->send($state)
            ->through([
                DivideSecret::class,
                SetMaxKeyLength::class,
                SetPrefixCharacter::class,
                SetPrefixFormat::class,
                SetPrefix::class,
                CreateChunks::class
            ])
            ->then(
                fn(SplitState $state) => $state->getShareCollection()
            );

        return $this;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}