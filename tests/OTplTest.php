<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OTpl package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace OTpl\Tests;

use Exception;
use OTpl\OTpl;
use PHPUnit\Framework\TestCase;
use PHPUtils\Str;

/**
 * Class OTplTest.
 *
 * @internal
 *
 * @coversNothing
 */
final class OTplTest extends TestCase
{
	/**
	 * @throws Exception
	 */
	public function testRenderWithFile(): void
	{
		self::matchesSnapshot('test-var-1.otpl', ['Franck', 23]);
		self::matchesSnapshot('test-var-2.otpl', ['name' => 'Franck', 'age' => 23]);
		self::matchesSnapshot('test-var-3.otpl', [
			['name' => 'Stella', 'age' => 41],
			['name' => 'Steve'],
			['name' => 'Franck', 'age' => 23],
		]);
		self::matchesSnapshot('test-attr.otpl', [
			'input' => [
				'id'          => 'name-field',
				'type'        => 'text',
				'placeholder' => 'Name',
				'value'       => 'toto',
			],
			'label' => 'Your name:',
		]);
		self::matchesSnapshot('test-loop.otpl', ['Apple', 'HTC', 'Samsung']);
		self::matchesSnapshot('sub/test-import.otpl', [
			'custom_import' => ['./../custom-import.otpl', 2017],
			'data_a'        => ['Franck', 23],
			'data_b'        => [
				'input' => [
					'id'          => 'name-field',
					'type'        => 'text',
					'placeholder' => 'Name',
					'value'       => 'toto',
				],
				'label' => 'Your name:',
			],
		]);
	}

	/**
	 * @throws Exception
	 */
	private static function compile(string $path, array $data): string
	{
		$DS       = \DIRECTORY_SEPARATOR;
		$root     = __DIR__ . $DS;
		$abs_path = $root . 'templates' . $DS . $path;
		$tpl      = new OTpl();

		return $tpl->parse($abs_path, true)
			->runGet($data);
	}

	/**
	 * @throws Exception
	 */
	private static function matchesSnapshot(string $path, array $data): void
	{
		$DS            = \DIRECTORY_SEPARATOR;
		$snapshots_dir = __DIR__ . $DS . 'snapshots';

		if (!\is_dir($snapshots_dir)) {
			\mkdir($snapshots_dir);
		}

		$content       = self::compile($path, $data);
		$hash          = Str::stringToURLSlug($path);
		$snapshot_file = $snapshots_dir . $DS . $hash . '.out';

		if (!\file_exists($snapshot_file)) {
			\file_put_contents($snapshot_file, $content);
		}

		self::assertStringEqualsFile($snapshot_file, $content);
	}
}
