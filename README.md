# Php-Email

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travisci]][link-travisci]
[![Coverage Status][ico-codecov]][link-codecov]
[![Style Status][ico-styleci]][link-styleci]
[![Scrutinizer Code Quality][ico-scrutinizer]][link-scrutinizer]

This is a domain-driven library for defining emails in PHP.

Php Email brings three major benefits over other similar libraries: 

1. Focusing on new versions of PHP. By using the newer versions of PHP (5.6+) we can leverage great features such as splat parameters and better type hinting.
1. Focusing on only the email, instead of transmission. In a domain-driven world, emails can and should exist separately from the delivery mechanism. By separating these concerns, this library decreases the size and complexity of the domain, while giving developers greater flexibility in how they use the library. 
1. Flexible content definitions. Emails have gone from a simple text string to highly stylized HTML to now just being templates stored in third-party services. Existing libraries do not provide enough flexibility to support everything developers need. Php Email attempts to correct this by creating guidelines for possible email content, but also allowing developers to define what they need.
  
## Install

### With Composer

```bash
composer require quartzy/php-email
```
  
## Usage
 
Building an email with HTML and text content would look like:

```php
<?php

use PhpEmail\Attachment\FileAttachment;
use PhpEmail\EmailBuilder;
use PhpEmail\Content\SimpleContent;

$email = EmailBuilder::email()
    ->withSubject('Welcome!')
    ->withContent(SimpleContent::text('Start your free trial now!!!'))
    ->from('me@test.com')
    ->to('you@yourbusiness.com')
    ->cc('cc@test.com')
    ->bcc('bcc@test.com')
    ->replyTo('reply.to@test.com')
    ->attach(new FileAttachment('/path/to/my/file.txt'))
    ->build();
```

Sending a templated email:

```php
<?php

use PhpEmail\EmailBuilder;
use PhpEmail\Content\TemplatedContent;

$content = new TemplatedContent('my_templates_id', ['firstName' => 'Billy']);

$email = EmailBuilder::email()
    ->withSubject('Welcome!')
    ->withContent($content)
    ->from('me@test.com')
    ->to('you@yourbusiness.com')
    ->build();
```
## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email [opensource@quartzy.com](mailto:opensource@quartzy.com) instead of using the issue tracker.

## Credits

- [Chris Muthig](https://github.com/camuthig)
- [All Contributors][link-contributors]


## License

The Apache License, v2.0. Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/quartzy/php-email.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-Apache%202.0-brightgreen.svg?style=flat-square
[ico-travisci]: https://img.shields.io/travis/quartzy/php-email.svg?style=flat-square
[ico-codecov]: https://img.shields.io/scrutinizer/coverage/g/quartzy/php-email.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/81520386/shield
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/quartzy/php-email.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/quartzy/php-email.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/quartzy/php-email
[link-travisci]: https://travis-ci.org/quartzy/php-email
[link-codecov]: https://scrutinizer-ci.com/g/quartzy/php-email
[link-styleci]: https://styleci.io/repos/81520386
[link-scrutinizer]: https://scrutinizer-ci.com/g/quartzy/php-email
[link-downloads]: https://packagist.org/packages/quartzy/php-email
[link-contributors]: ../../contributors
