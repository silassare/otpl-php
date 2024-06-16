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

/**
 * Class OTplData.
 */
final class OTplData
{
	/**
	 * @var mixed
	 */
	private mixed $data;

	/**
	 * @var OTpl
	 */
	private OTpl $context;

	/**
	 * OTplData constructor.
	 *
	 * @param mixed $data
	 * @param OTpl  $context
	 */
	public function __construct(mixed $data, OTpl $context)
	{
		$this->data    = $data;
		$this->context = $context;
	}

	/**
	 * @return OTpl
	 */
	public function getContext(): OTpl
	{
		return $this->context;
	}

	/**
	 * @return mixed
	 */
	public function getData(): mixed
	{
		return $this->data;
	}
}
