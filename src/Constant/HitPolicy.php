<?php

namespace SteffenBrand\DmnDecisionTables\Constant;

/**
 * Class HitPolicy
 * @package SteffenBrand\DmnDecisionTables\Constant
 */
class HitPolicy
{
    const UNIQUE_POLICY = 'UNIQUE';
    const FIRST_POLICY = 'FIRST';
    const PRIORITY_POLICY = 'PRIORITY';
    const ANY_POLICY = 'ANY';
    const COLLECT_POLICY = 'COLLECT';
    const RULE_ORDER_POLICY = 'RULE ORDER';
    const OUTPUT_ORDER_POLICY = 'OUTPUT ORDER';

    const ALLOWED_HIT_POLICIES = [
        self::UNIQUE_POLICY,
        self::FIRST_POLICY,
        self::PRIORITY_POLICY,
        self::ANY_POLICY,
        self::COLLECT_POLICY,
        self::RULE_ORDER_POLICY,
        self::OUTPUT_ORDER_POLICY
    ];
}