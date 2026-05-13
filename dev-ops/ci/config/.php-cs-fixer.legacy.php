<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        dirname(__DIR__, 3) . '/src',
    ])
    ->notPath([
        'Repository/Entity'
    ])
;

return (new Config())
    ->setFinder($finder)
    ->setRiskyAllowed(false)
    ->setCacheFile(dirname(__DIR__) . '/cache/.php-cs-fixer.legacy.cache')
    ->setRules([
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        '@PHP83Migration' => true,

        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'compact_nullable_typehint' => true,
        'concat_space' => ['spacing' => 'one'],
        'method_chaining_indentation' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_imports' => ['imports_order' => ['class', 'function', 'const']],
        'phpdoc_order' => true,
        'self_static_accessor' => true,
        'single_line_throw' => false,
        'visibility_required' => ['elements' => ['property', 'method', 'const']],
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'phpdoc_separation' => [
            'groups' => [
                ['Assert\\*'],
                ['ORM\\*'],
            ]
        ],
    ])
;
