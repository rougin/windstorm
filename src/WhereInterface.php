<?php

namespace Rougin\Windstorm;

interface WhereInterface
{
    public function equals($value);

    public function greaterThan($value);

    public function greaterThanOrEqualTo($value);

    public function isFalse();

    public function isNotNull();

    public function isNull();

    public function isTrue();

    public function lessThan($value);

    public function lessThanOrEqualTo($value);
}
