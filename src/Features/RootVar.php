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

namespace OTpl\Features;

use OTpl\OTplUtils;

/**
 * Class RootVar.
 */
final class RootVar
{
	// root data alias $ replacement
	public const REG_ROOT_KEY = '#[$]([^\w.])#';

	public const REG_JS_CHAIN_A = '#([$][a-zA-Z0-9_]*|\])\.(\w+)#';

	public const REG_JS_CHAIN_B = '#([$])\[(.+?)\]#';

	public const REG_AT_VAR = '#(?!\w)@var(\s+[$][a-zA-Z_])#';

	// shouldn't match @import(
	public const REG_AT_PLUGIN = '#(?!\w)@((?!import\()[a-zA-Z_][a-zA-Z0-9_]+)\((.)#';

	/**
	 * @param array $in
	 *
	 * @return string
	 */
	public static function root_key(array $in): string
	{
		return OTplUtils::OTPL_DATA_REF . $in[1];
	}

	/**
	 * @param array $in
	 *
	 * @return string
	 */
	public static function js_key_chain(array $in): string
	{
		$txt                             = '';
		@list($found, $start, $key_name) = $in;

		if (!empty($found)) {
			if (\preg_match(OTplUtils::OTPL_STR_KEY_NAME_REG, $key_name)) {
				$key_name = "'{$key_name}'";
			}

			if ('$' === $start) {
				// $.toto -> $otpl_data['toto']
				$txt .= OTplUtils::OTPL_DATA_REF . "[{$key_name}]";
			} elseif (']' === $start) {
				// ].toto -> ]['totot']
				$txt .= "][{$key_name}]";
			} else {
				// $papa.toto -> $papa['toto']

				$txt .= $start . "[{$key_name}]";
			}
		}

		return $txt;
	}

	/**
	 * @param array $in
	 *
	 * @return string
	 */
	public static function var_replace(array $in): string
	{
		return $in[1];
	}

	/**
	 * @param array $in
	 *
	 * @return string
	 */
	public static function plugin_replace(array $in): string
	{
		$pl_name = $in[1];
		$next    = $in[2];

		if (')' === $next) {
			return "OTplUtils::runPlugin('{$pl_name}')";
		}

		return "OTplUtils::runPlugin('{$pl_name}'," . $next;
	}

	public static function register(): void
	{
		OTplUtils::addReplacer(self::REG_ROOT_KEY, [self::class, 'root_key']);
		OTplUtils::addReplacer(self::REG_JS_CHAIN_A, [self::class, 'js_key_chain']);
		OTplUtils::addReplacer(self::REG_JS_CHAIN_B, [self::class, 'js_key_chain']);

		OTplUtils::addCleaner(self::REG_AT_VAR, [self::class, 'var_replace']);
		OTplUtils::addCleaner(self::REG_AT_PLUGIN, [self::class, 'plugin_replace']);
	}
}
