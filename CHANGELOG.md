### v2.0.0 (2024-06-16)
 - OTplResolver removed to make use of `PHPUtils\FS\PathUtils`
 - PHP >=8.1 is now required

### v1.1.9 (2019-09-04)

 - It is now possible to inject parent root data to imported template
   - if both parent data and injected data are array

### v1.1.8 (2019-08-04)

 - str_replace bug fix

### v1.1.7 (2019-14-03)

 - cache directory creation error fixed
 - license updated to MIT
 
 ### v1.1.6 (2018-17-10)

 - php source moved to a new project repo
 - php namespace added
 - from now compiled template are stored in otpl_done/version

### v1.1.5 (2018-05-08)

 - some bug that leads to synthax error fixed

### v1.1.4 (2017-02-28)

 - new test output (cool) 
 - OTpl register method rewritten both for js and php
 - some test template added
 - OPathResolver renamed to OTplResolver

### v1.1.3 (2017-02-25)

 - relative path resolve support for otpl-js

### v1.1.2 (2016-10-06)

 - OTemplate renamed to OTpl
 - the template language change
 - features and plugins concept added
 - foreach removed from otpl feature keywords
 - loop both on array and object added
 - PHP
  - OPathResolver class added for relative path resolving when trying to import template file

### v1.0.1 (2016-08)

 - First stable version of OTemplate for JS and PHP