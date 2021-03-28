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
 * Class OTplData
 */
final class OTplData
{
	/**
	 * @var mixed
	 */
	private $data;

	/**
	 * @var \OTpl\OTpl
	 */
	private $context;

	/**
	 * OTplData constructor.
	 *
	 * @param mixed      $data
	 * @param \OTpl\OTpl $context
	 */
	public function __construct($data, OTpl $context)
	{
		$this->data    = $data;
		$this->context = $context;
	}

	/**
	 * @return \OTpl\OTpl
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}
}
