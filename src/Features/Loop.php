<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of Otpl.
	 */

	namespace OTpl\Features;

	use OTpl\OTplUtils;

	/**
	 * Class Loop
	 * @package OTpl\Features
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
			} else {
				$value = $key;

				return "foreach($data as $value){";
			}
		}

		public static function register()
		{
			OTplUtils::addReplacer(self::REG, [self::class, 'exec']);
		}
	}