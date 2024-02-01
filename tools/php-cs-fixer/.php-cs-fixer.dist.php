<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/../..')
    ->exclude('bin')
    ->exclude('config')
    ->exclude('docker')
    ->exclude('fixtures')
    ->exclude('templates')
    ->exclude('translations')
    ->exclude('var')
    ->exclude('tests')
    ->notPath('public/index.php')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'align_multiline_comment' => true,
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'class_definition' => ['single_line' => false],
        'class_reference_name_casing' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'compact_nullable_type_declaration' => true,
        'concat_space' => ['spacing' => 'one'],
        'echo_tag_syntax' => ['format' => 'long'],
        'linebreak_after_opening_tag' => true,
        'mb_str_functions' => true,
        'multiline_comment_opening_closing' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
        'no_alternative_syntax' => true,
        'no_null_property_initialization' => true,
        'no_php4_constructor' => true,
        'no_superfluous_elseif' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_unreachable_default_argument_value' => true,
        'no_unset_on_property' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_useless_sprintf' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'php_unit_dedicate_assert' => true,
        'php_unit_strict' => true,
        'php_unit_set_up_tear_down_visibility' => true,
        'phpdoc_add_missing_param_annotation' => false,
        'phpdoc_order' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'pow_to_exponentiation' => true,
        'random_api_migration' => true,
        'return_assignment' => true,
        'self_accessor' => false,
        'semicolon_after_instruction' => true,
        'simplified_null_return' => true,
        'single_line_throw' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'string_line_ending' => true,
        'ternary_to_null_coalescing' => true,
        'types_spaces' => false,
        'void_return' => true,
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => false,
        ],
    ])
    ->setFinder($finder)
    ;
