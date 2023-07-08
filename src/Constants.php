<?php

namespace JustSomeCode\ShamirSecretSharing;

final class Constants
{
    public const ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyz.,:;-+*#%[]{}()|';
    public const DECIMAL = '0123456789';
    public const PADDING = '=';
    public const MAX_SHARES = 257;
    public const MIN_SHARES = 1;

    public const CHUNK_TO_PRIME = [
        1 => 257,
        2 => 65537,
        3 => 16777259,
        4 => 4294967311,
        5 => 1099511627791,
        6 => 281474976710677,
        7 => 72057594037928017
    ];
}