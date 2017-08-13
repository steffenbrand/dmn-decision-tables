<?php

namespace SteffenBrand\DmnDecisionTables\Constant;

/**
 * Class CollectOperator
 * @package SteffenBrand\DmnDecisionTables\Constant
 */
class CollectOperator
{
    const LIST_OPERATOR = 'LIST';
    const SUM_OPERATOR = 'SUM';
    const MIN_OPERATOR = 'MIN';
    const MAX_OPERATOR = 'MAX';
    const COUNT_OPERATOR = 'COUNT';

    const ALLOWED_COLLECT_OPERATORS = [
        self::LIST_OPERATOR,
        self::SUM_OPERATOR,
        self::MIN_OPERATOR,
        self::MAX_OPERATOR,
        self::COUNT_OPERATOR
    ];
}