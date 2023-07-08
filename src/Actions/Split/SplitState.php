<?php

namespace JustSomeCode\ShamirSecretSharing\Actions\Split;

use JustSomeCode\ShamirSecretSharing\DTO\Share;

class SplitState
{
    protected array $y_polynomial_values = [];
    protected array $share_collection = [];
    protected int $max_key_length = 0;
    protected string $prefix_char = '';
    protected string $prefix_format = '';
    protected string $prefix;

    public function __construct(
        public readonly Share $share
    ){}

    public function setYPolynomialValues(array $values): void
    {
        $this->y_polynomial_values = $values;
    }

    public function getYPolynomialValues(): array
    {
        return $this->y_polynomial_values;
    }

    public function setMaxKeyLength(int $length): void
    {
        $this->max_key_length = $length;
    }

    public function getMaxKeyLength(): int
    {
        return $this->max_key_length;
    }

    public function setPrefixChar(string $prefix_char): void
    {
        $this->prefix_char = $prefix_char;
    }

    public function getPrefixChar(): string
    {
        return $this->prefix_char;
    }

    public function setPrefixFormat(string $prefix_format): void
    {
        $this->prefix_format = $prefix_format;
    }

    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }

    public function getPrefixFormat(): string
    {
        return $this->prefix_format;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function setShareCollection(array $share_collection): void
    {
        $this->share_collection = $share_collection;
    }

    public function getShareCollection(): array
    {
        return $this->share_collection;
    }
}