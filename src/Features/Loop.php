<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OTpl package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OTpl\Features;

use OTpl\OTplUtils;

/**
 * Class Loop
 */
final class Loop
{
	const REG = "#loop[\s]*\([\s]*(.+?)[\s]*\:[\s]*([$][a-zA-Z0-9_]+)[\s]*(?:\:[\s]*([$][a-zA-Z0-9_]+)[\s]*)?\)[\s]*\{#";

	/**
	 * @param array $in
	 *
	 * @return string
	 */
	public static function exec(array $in)
	{
		$data = $in[1];
		$key  = $in[2];

		if (isset($in[3])) {
			$value = $in[3];

			return "foreach($data as $key=>$value){";
		}
		$value = $key;

		return "foreach($data as $value){";
	}

	public static function register()
	{
		OTplUtils::addReplacer(self::REG, [self::class, 'exec']);
	}
}
