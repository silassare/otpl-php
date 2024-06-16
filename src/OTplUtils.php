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

/**
 * Copyright (c) 2017-present, Emile Silas Sare.
 *
 * This file is part of OTpl package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OTpl;

use Exception;
use PHPUtils\FS\PathUtils;
use RuntimeException;

/**
 * Class OTplUtils.
 */
final class OTplUtils
{
	public const OTPL_STR_KEY_NAME_REG = '#^[a-z_][a-z0-9_]*$#i';

	public const OTPL_ROOT_REF = '$otpl_root';

	public const OTPL_DATA_REF = '$otpl_data';

	/**
	 * @var array<array{string, callable}>
	 */
	private static array $clean_hooks = [];

	/**
	 * @var array<array{string, callable}>
	 */
	private static array $replace_hooks = [];

	/**
	 * @var callable[]
	 */
	private static array $plugins = [];

	/**
	 * @param string $url
	 *
	 * @return bool
	 */
	public static function isTplFile(string $url): bool
	{
		return \file_exists($url);
	}

	/**
	 * @param string   $reg
	 * @param callable $callable
	 */
	public static function addCleaner(string $reg, callable $callable): void
	{
		self::$clean_hooks[] = [$reg, $callable];
	}

	/**
	 * @param string   $reg
	 * @param callable $callable
	 */
	public static function addReplacer(string $reg, callable $callable): void
	{
		self::$replace_hooks[] = [$reg, $callable];
	}

	/**
	 * @param string   $name
	 * @param callable $callable
	 */
	public static function addPlugin(string $name, callable $callable): void
	{
		self::$plugins[$name] = $callable;
	}

	/**
	 * @return array<array{string, callable}>
	 */
	public static function getCleanHooks(): array
	{
		return self::$clean_hooks;
	}

	/**
	 * @return array<array{string, callable}>
	 */
	public static function getReplaceHooks(): array
	{
		return self::$replace_hooks;
	}

	/**
	 * @return callable[]
	 */
	public static function getPlugins(): array
	{
		return self::$plugins;
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 *
	 * @throws Exception
	 */
	public static function runPlugin($name): mixed
	{
		if (isset(self::$plugins[$name])) {
			$fn   = self::$plugins[$name];
			$args = \array_slice(\func_get_args(), 1);

			if (\is_callable($fn)) {
				return \call_user_func_array($fn, $args);
			}

			throw new Exception("OTPL : plugin `{$name}` is not callable.");
		}

		throw new Exception("OTPL : plugin `{$name}` is not defined.");
	}

	/**
	 * @param string $src
	 *
	 * @return false|string
	 */
	public static function loadFile(string $src): false|string
	{
		if (empty($src) || !\file_exists($src) || !\is_file($src) || !\is_readable($src)) {
			throw new RuntimeException("OTPL : Unable to access file at : {$src}");
		}

		return \file_get_contents($src);
	}

	/**
	 * @param string $url
	 * @param        $data
	 *
	 * @return string
	 *
	 * @throws Exception
	 */
	public static function importExec(string $url, mixed $data): string
	{
		$o = new OTpl();
		$o->parse($url);

		\ob_start();
		$o->runWith($data);

		return \ob_get_clean();
	}

	/**
	 * @param OTplData $root
	 * @param string   $url
	 * @param mixed    $data
	 * @param bool     $inject_root
	 *
	 * @return bool|string
	 *
	 * @throws Exception
	 */
	public static function importCustom(OTplData $root, string $url, mixed $data =  [], bool $inject_root = true): bool|string
	{
		if ('' === $url) {
			throw new RuntimeException('OTPL : nothing to import, empty url.');
		}

		$src_dir = $root->getContext()
			->getSrcDir();

		$root_dir  = $src_dir ?: OTPL_ROOT_DIR;
		$url       = PathUtils::resolve($root_dir, $url);
		$root_data = $root->getData();

		if ($inject_root && \is_array($root_data) && \is_array($data)) {
			$data = \array_replace($root_data, $data);
		}

		if (self::isTplFile($url)) {
			return self::importExec($url, $data);
		}

		return self::loadFile($url);
	}
}
