<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OTpl package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OTpl;

/**
 * Class OTplUtils
 */
final class OTplUtils
{
	const OTPL_STR_KEY_NAME_REG = '#^[a-z_][a-z0-9_]*$#i';

	const OTPL_ROOT_REF = '$otpl_root';

	const OTPL_DATA_REF = '$otpl_data';

	/**
	 * @var callable[]
	 */
	private static $clean_hooks = [];

	/**
	 * @var callable[]
	 */
	private static $replace_hooks = [];

	/**
	 * @var callable[]
	 */
	private static $plugins = [];

	/**
	 * @param string $url
	 *
	 * @return false|int
	 */
	public static function isTplFile($url)
	{
		return \file_exists($url);
	}

	/**
	 * @param string   $reg
	 * @param callable $callable
	 */
	public static function addCleaner($reg, $callable)
	{
		self::$clean_hooks[] = [$reg, $callable];
	}

	/**
	 * @param string   $reg
	 * @param callable $callable
	 */
	public static function addReplacer($reg, $callable)
	{
		self::$replace_hooks[] = [$reg, $callable];
	}

	/**
	 * @param string   $name
	 * @param callable $callable
	 */
	public static function addPlugin($name, $callable)
	{
		self::$plugins[$name] = $callable;
	}

	/**
	 * @return callable[]
	 */
	public static function getCleanHooks()
	{
		return self::$clean_hooks;
	}

	/**
	 * @return callable[]
	 */
	public static function getReplaceHooks()
	{
		return self::$replace_hooks;
	}

	/**
	 * @return callable[]
	 */
	public static function getPlugins()
	{
		return self::$plugins;
	}

	/**
	 * @param $name
	 *
	 * @throws \Exception
	 *
	 * @return mixed
	 */
	public static function runPlugin($name)
	{
		if (isset(self::$plugins[$name])) {
			$fn   = self::$plugins[$name];
			$args = \array_slice(\func_get_args(), 1);

			if (\is_callable($fn)) {
				return \call_user_func_array($fn, $args);
			}

			throw new \Exception("OTPL : plugin `$name` is not callable.");
		}

		throw new \Exception("OTPL : plugin `$name` is not defined.");
	}

	/**
	 * @param $src
	 *
	 * @throws \Exception
	 *
	 * @return bool|string
	 */
	public static function loadFile($src)
	{
		if (empty($src) || !\file_exists($src) || !\is_file($src) || !\is_readable($src)) {
			throw new \Exception("OTPL : Unable to access file at : $src");
		}

		return \file_get_contents($src);
	}

	/**
	 * @param $url
	 * @param $data
	 *
	 * @throws \Exception
	 *
	 * @return string
	 */
	public static function importExec($url, $data)
	{
		$o = new OTpl();
		$o->parse($url);

		\ob_start();
		$o->runWith($data);

		return \ob_get_clean();
	}

	/**
	 * @param \OTpl\OTplData $root
	 * @param string         $url
	 * @param mixed          $data
	 * @param bool           $inject_root
	 *
	 * @throws \Exception
	 *
	 * @return bool|string
	 */
	public static function importCustom(OTplData $root, $url, $data, $inject_root = true)
	{
		if (!\is_string($url) || !\strlen($url)) {
			throw new \Exception('OTPL : nothing to import, empty url.');
		}

		$src_dir = $root->getContext()
						->getSrcDir();

		$root_dir  = $src_dir ? $src_dir : OTPL_ROOT_DIR;
		$url       = OTplResolver::resolve($root_dir, $url);
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
