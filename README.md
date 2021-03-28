# OTPL

A simple template system, write once run everywhere with JavaScript (nodejs or in browser ), PHP ...

## Your contributions are welcomed

-   [JS Project](https://github.com/silassare/otpl-js/)
-   [PHP Project](https://github.com/silassare/otpl-php/)

## Setup with composer

```sh
$ composer require silassare/otpl-php
```

## Use case

### Input: your template.otpl file content

```html
<label for="<% $.input.id %>"><% $.label.text %></label>
<input <% @HtmlSetAttr($.input) %> />
```

### Usage: php

```php
<?php

require_once "vendor/autoload.php";

$otpl = new \OTpl\OTpl();
$otpl->parse('template.otpl');
$data = array(
	'label' => array(
		'text' => 'Your password please :',
	),
	'input' => array(
		'id' => 'pass_field',
		'type' => 'password',
		'name' => 'pass'
	)
);

$otpl->runWith($data);

```

### Output

```html
<label for="pass_field">Your password please :</label>
<input type="password" id="pass_field" name="pass" />
```
