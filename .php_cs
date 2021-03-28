<?php

$header = <<<'EOF'
Copyright (c) 2017-present, Emile Silas Sare

This file is part of OTpl package.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;
$finder = PhpCsFixer\Finder::create();
$config = PhpCsFixer\Config::create();

$finder->in(__DIR__.'/src/')
           ->name('*.php')
           ->notPath('ignore')
           ->notPath('test')
           ->notPath('otpl_done')
           ->ignoreDotFiles(true)
           ->ignoreVCS(true);

return $config
        ->setRules([
                'align_multiline_comment'                       => true,
                'array_indentation'                             => true,
                'array_syntax'                                  => ['syntax' => 'short'],
                'binary_operator_spaces'                        => [
                        'operators' => [
                                '='  => 'align',
                                '=>' => 'align',
                        ],
                ],
                'blank_line_after_namespace'                    => true,
                'blank_line_before_statement'                   => [
                        'statements' => [
                                'break',
                                'continue',
                                'declare',
                                'do',
                                'for',
                                'foreach',
                                'if',
                                'include',
                                'include_once',
                                'require',
                                'require_once',
                                'return',
                                'switch',
                                'throw',
                                'try',
                                'while',
                                'yield',
                        ],
                ],
                'braces'                                        => true,
                'cast_spaces'                                   => true,
                'class_attributes_separation'                   => ['elements' => ['const', 'method', 'property']],
                'combine_consecutive_issets'                    => true,
                'combine_consecutive_unsets'                    => true,
                'compact_nullable_typehint'                     => true,
                'concat_space'                                  => ['spacing' => 'one'],
                'declare_equal_normalize'                       => ['space' => 'none'],
               // 'declare_strict_types'                          => true,
                'dir_constant'                                  => true,
                'elseif'                                        => true,
                'encoding'                                      => true,
                'full_opening_tag'                              => true,
                'function_declaration'                          => true,
                'header_comment'                                => [
                        'header'       => $header,
                        'comment_type' => 'PHPDoc',
                        'separate'     => 'both',
                        'location'     => 'after_open'
                ],
                'indentation_type'                              => true,
                'is_null'                                       => true,
                'line_ending'                                   => true,
                'list_syntax'                                   => ['syntax' => 'long'],
                'logical_operators'                             => true,
                'lowercase_cast'                                => true,
                'lowercase_constants'                           => true,
                'lowercase_keywords'                            => true,
                'lowercase_static_reference'                    => true,
                'magic_constant_casing'                         => true,
                'method_argument_space'                         => ['ensure_fully_multiline' => true],
                'modernize_types_casting'                       => true,
                'multiline_comment_opening_closing'             => true,
                'multiline_whitespace_before_semicolons'        => true,
                'native_constant_invocation'                    => true,
                'native_function_casing'                        => true,
                'native_function_invocation'                    => true,
                'new_with_braces'                               => false,
                'no_alias_functions'                            => true,
                'no_alternative_syntax'                         => true,
                'no_blank_lines_after_class_opening'            => true,
                'no_blank_lines_after_phpdoc'                   => true,
                'no_blank_lines_before_namespace'               => true,
                'no_closing_tag'                                => true,
                'no_empty_comment'                              => true,
                'no_empty_phpdoc'                               => true,
                'no_empty_statement'                            => true,
                'no_extra_blank_lines'                          => true,
                'no_homoglyph_names'                            => true,
                'no_leading_import_slash'                       => true,
                'no_leading_namespace_whitespace'               => true,
                'no_mixed_echo_print'                           => ['use' => 'print'],
                'no_multiline_whitespace_around_double_arrow'   => true,
                'no_null_property_initialization'               => true,
                'no_php4_constructor'                           => true,
                'no_short_bool_cast'                            => true,
                'no_short_echo_tag'                             => true,
                'no_singleline_whitespace_before_semicolons'    => true,
                'no_spaces_after_function_name'                 => true,
                'no_spaces_inside_parenthesis'                  => true,
                'no_superfluous_elseif'                         => true,
                'no_superfluous_phpdoc_tags'                    => false,
                'no_trailing_comma_in_list_call'                => true,
                'no_trailing_comma_in_singleline_array'         => true,
                'no_trailing_whitespace'                        => true,
                'no_trailing_whitespace_in_comment'             => true,
                'no_unneeded_control_parentheses'               => true,
                'no_unneeded_curly_braces'                      => true,
                'no_unneeded_final_method'                      => true,
                'no_unreachable_default_argument_value'         => true,
                'no_unset_on_property'                          => false,
                'no_unused_imports'                             => true,
                'no_useless_else'                               => true,
                'no_useless_return'                             => true,
                'no_whitespace_before_comma_in_array'           => true,
                'no_whitespace_in_blank_line'                   => true,
                'non_printable_character'                       => true,
                'normalize_index_brace'                         => true,
                'object_operator_without_whitespace'            => true,
                'ordered_class_elements'                        => [
                        'order' => [
                                'use_trait',
                                'constant_public',
                                'constant_protected',
                                'constant_private',
                                'property_public_static',
                                'property_protected_static',
                                'property_private_static',
                                'property_public',
                                'property_protected',
                                'property_private',
                                'construct',
                                'destruct',
                                'method_public',
                                'method_protected',
                                'method_private',
                                'method_public_static',
                                'method_protected_static',
                                'method_private_static',
                                'magic',
                                'phpunit',
                        ],
                ],
                'ordered_imports'                               => true,
                'ordered_interfaces'                            => [
                        'direction' => 'ascend',
                        'order'     => 'alpha',
                ],
                'phpdoc_add_missing_param_annotation'           => true,
                'phpdoc_align'                                  => true,
                'phpdoc_annotation_without_dot'                 => true,
                'phpdoc_indent'                                 => true,
                'phpdoc_no_access'                              => true,
                'phpdoc_no_empty_return'                        => true,
                'phpdoc_no_package'                             => true,
                'phpdoc_order'                                  => true,
                'phpdoc_return_self_reference'                  => true,
                'phpdoc_scalar'                                 => true,
                'phpdoc_separation'                             => true,
                'phpdoc_single_line_var_spacing'                => true,
                'phpdoc_to_comment'                             => true,
                'phpdoc_trim'                                   => true,
                'phpdoc_trim_consecutive_blank_line_separation' => true,
                'phpdoc_types'                                  => ['groups' => ['simple', 'meta']],
                'phpdoc_types_order'                            => true,
                'phpdoc_var_without_name'                       => true,
                'pow_to_exponentiation'                         => true,
                'protected_to_private'                          => true,
                'return_assignment'                             => true,
                'return_type_declaration'                       => ['space_before' => 'none'],
                'self_accessor'                                 => true,
                'semicolon_after_instruction'                   => true,
                'set_type_to_cast'                              => true,
                'short_scalar_cast'                             => true,
                'simplified_null_return'                        => false,
                'single_blank_line_at_eof'                      => true,
                'single_import_per_statement'                   => true,
                'single_line_after_imports'                     => true,
                'single_quote'                                  => true,
                'standardize_not_equals'                        => true,
                // 'ternary_to_null_coalescing'                    => true, // PHP 7
                'trailing_comma_in_multiline_array'             => true,
                'trim_array_spaces'                             => true,
                'unary_operator_spaces'                         => true,
                'visibility_required'                           => [
                        'elements' => [
                //              'const', // PHP 7.1
                                'method',
                                'property',
                        ],
                ],
               // 'void_return'                                   => true,
                'whitespace_after_comma_in_array'               => true,

        ])
        ->setRiskyAllowed(true)
        ->setIndent("\t")
        ->setLineEnding("\n")
        ->setFinder($finder);
