<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of Otpl.
	 */

	namespace OTpl\Features;

	use OTpl\OTpl;
	use OTpl\OTplUtils;

	/**
	 * Class Import
	 *
	 * @package OTpl\Features
	 */
	final class Import
	{
		// @import(url [,data]) replacement
		// const REG = '#@import\([\s]*?[\'"]?(.*?)[\'"]?(?:[\s]*,[\s]*(.+?)[\s]*)?[\s]*\)#';
		const REG = '#@import\([\s]*?([\'"]?(.*?)[\'"]?)(?:[\s]*,[\s]*(.+?)[\s]*)?[\s]*\)#';

		/**
		 * @param array      $in
		 * @param \OTpl\OTpl $context
		 *
		 * @return string
		 * @throws \Exception
		 */
		public static function exec(array $in, OTpl $context)
		{
			$match     = $in[0];

			return ' OTplUtils::importCustom( $otpl_root, ' . preg_replace("#^@import\([\s]*#", '', $match);
		}

		public static function register()
		{
			OTplUtils::addReplacer(self::REG, [self::class, 'exec']);
		}
	}