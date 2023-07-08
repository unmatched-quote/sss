<?php

namespace JustSomeCode\ShamirSecretSharing;

use JustSomeCode\ShamirSecretSharing\DTO\Share;
use JustSomeCode\ShamirSecretSharing\Actions\Split\SplitAction;

function share(string $secret, int $shares, int $threshold): array
{
    $share = new Share($secret, $shares, $threshold);

    $action = new SplitAction();

    return $action->execute($share)->getResult();
}

function recover()
{}

function get_num_byes_for_encryption(int $shares): int
{
    return (int)ceil(log($shares, 2) / 8);
}

function unpack_str_bin_to_dec(string $secret, int $size = 1): array
{
    $result = [];
    $counter = 0;
    $sum = 0;

    $byte_array = unpack('C*', $secret);

    foreach($byte_array as $byte)
    {
        $sum = bcadd($sum, bcmul($byte, bcpow(2, $counter * 8)));

        if($size === ++$counter)
        {
            $result[] = $sum;
            $sum = '';
            $counter = 0;
        }
    }

    if($counter > 0) $result[] = $sum;

    return $result;
}

function generate_polynomial_coefficients(int $threshold, int $prime): array
{
    $coefficients = [];

    for($i = 0; $i < $threshold - 1; $i++)
    {
        $coefficients[] = modulo_via_prime(random_int(1, PHP_INT_MAX), $prime);
    }

    return $coefficients;
}

function horner_method(int $x_coordinate, array $coefficients, int $prime): int
{
    $y_coordinate = 0;

    foreach($coefficients as $coefficient)
    {
        $y_coordinate = modulo_via_prime($x_coordinate * $y_coordinate + $coefficient, $prime);
    }

    return $y_coordinate;
}

function modulo_via_prime(int $number, int $prime): string
{
    $modulo = bcmod($number, $prime);

    return ($modulo < 0) ? bcadd($modulo, $prime) : $modulo;
}

function inverse_modulo_via_prime(int $number, int $prime): string
{
    $mod = bcmod($number, $prime);
    $r = greatest_common_divisor($prime, abs($mod));
    $r = ($mod < 0) ? -$r[2] : $r[2];

    return bcmod(bcadd($prime, $r), $prime);
}

function greatest_common_divisor(int $a, string $b): array
{
    if($b === '0') return [$a, 1, 0];

    $div    = floor(bcdiv($a, $b));
    $mod    = bcmod($a, $b);
    $decomp = greatest_common_divisor($b, $mod);

    return [$decomp[0], $decomp[2], $decomp[1] - $decomp[2] * $div];
}

function get_max_key_length(int $bytes, string $decimals = Constants::DECIMAL, string $alphabet = Constants::ALPHABET): int
{
    $max = bcpow(2, $bytes * 8);

    $converted = convert_base($max, $decimals, $alphabet);

    return strlen($converted);
}

function convert_base(string $in_number, string $from, string $to): string
{
    if($from === $to) return $in_number;

    $from_base  = str_split($from, 1);
    $to_base    = str_split($to, 1);
    $number     = str_split($in_number, 1);
    $from_len   = strlen($from);
    $to_len     = strlen($to);
    $number_len = strlen($in_number);
    $result     = '';

    if ($to === '0123456789')
    {
        $result = 0;

        for($i = 1; $i <= $number_len; $i++)
        {
            $result = bcadd(
                $result,
                bcmul(array_search($number[$i - 1], $from_base, true), bcpow($from_len, $number_len - $i))
            );
        }

        return $result;
    }

    if($from !== '0123456789')
    {
        $base10 = convert_base($in_number, $from, '0123456789');
    }
    else
    {
        $base10 = $in_number;
    }

    if($base10 < strlen($to))
    {
        return $to_base[$base10];
    }

    while($base10 !== '0')
    {
        $retVal = $to_base[bcmod($base10, $to_len)].$retVal;

        $base10 = bcdiv($base10, $to_len, 0);
    }

    return $result;
}