<?php

namespace SteffenBrand\DmnDecisionTables\Constant;

/**
 * Class ExpressionLanguage
 * @package SteffenBrand\DmnDecisionTables\Constant
 */
class ExpressionLanguage
{
    const FEEL_LANGUAGE = 'feel';
    const JAVASCRIPT_LANGUAGE = 'javascript';
    const GROOVY_LANGUAGE = 'groovy';
    const PYTHON_LANGUAGE = 'python';
    const JRUBY_LANGUAGE = 'jruby';
    const JUEL_LANGUAGE = 'juel';

    const ALLOWED_EXPRESSION_LANGUAGES = [
        self::FEEL_LANGUAGE,
        self::JAVASCRIPT_LANGUAGE,
        self::GROOVY_LANGUAGE,
        self::PYTHON_LANGUAGE,
        self::JRUBY_LANGUAGE,
        self::JUEL_LANGUAGE
    ];
}