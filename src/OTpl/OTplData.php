<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of Otpl.
	 */

	namespace OTpl;

	/**
	 * Class OTplData
	 * @package OTpl
	 */
	final class OTplData
	{
		private $data;
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