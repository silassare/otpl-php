<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use OLIUP\CS\PhpCS;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = Finder::create();

$finder->in([
	__DIR__ . '/src',
	__DIR__ . '/tests',
])
	->notPath('otpl_done')
	->notPath('.gobl')
	->notPath('blate_cache')
	->notPath('vendor')
	->ignoreDotFiles(true)
	->ignoreVCS(true);

$header = <<<'EOF'
Copyright (c) 2017-present, Emile Silas Sare

This file is part of OTpl package.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$rules = [
	'header_comment' => [
		'header'       => $header,
		'comment_type' => 'PHPDoc',
		'separate'     => 'both',
		'location'     => 'after_open'
	],
	'fopen_flags'    => ['b_mode' => true],
];

return (new PhpCS())->mergeRules($finder, $rules)
	->setRiskyAllowed(true)
	->setParallelConfig(ParallelConfigFactory::detect());
