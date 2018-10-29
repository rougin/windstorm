<?php

namespace Rougin\Windstorm;

interface WhereInterface
{
    public function equals($value);

    public function notEqualTo($value);

    public function greaterThan($value);

    public function greaterThanOrEqualTo($value);

    public function in(array $values);

    public function notIn(array $values);

    public function isFalse();

    public function isNotNull();

    public function isNull();

    public function isTrue();

    public function lessThan($value);

    public function lessThanOrEqualTo($value);

    public function like($value);

    public function notLike($value);
}
