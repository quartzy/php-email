#Php-Email

This is a domain-driven library for defining emails in PHP.

Php Email brings three major benefits over other similar libraries: 

1. Focusing on new versions of PHP. By using the latest versions of PHP we can leverage great features such as splat parameters and better type hinting.
1. Focusing on only the email, instead of transmission. In a domain-driven world, emails can and should exist separately from the delivery mechanism. By separating these concerns, this library decreases the size and complexity of the domain, while giving developers greater flexibility in how they use the library. 
1. Flexible content definitions. Emails have gone from a simple text string to highly stylized HTML to now just being templates stored in third-party services. Existing libraries do not provide enough flexibility to support everything developers need. Php Email attempts to correct this by creating guidelines for possible email content, but also allowing developers to define what they need.
  
  
## Examples
 
Sending a standard content email: 

```php
<?php

// Create a basic email
$from       = new PhpEmail\Address('from@test.com');
$recipients = [
    new PhpEmail\Address('user@test.com'), 
    new PhpEmail\Address('named@test.com', 'Named User'),
];
$subject    = 'Domain Driven Emails';
$content    = new PhpEmail\Content\SimpleContent('<b>Html emails!</b>', 'Text emails!');

$email = new PhpEmail\Email($subject, $content, $from, $recipients);

// Add CC and BCC recipients
$ccs = [
    new PhpEmail\Address('cc@test.com'),
];

$email->addCcRecipients(...$ccs);

$bccs = [
    new PhpEmail\Address('bcc@test.com'),
];

$email->addBccRecipients(...$bccs);

// Add Reply-To addresses
$replyTos = [
    new PhpEmail\Address('firstReply@test.com'),
    new PhpEmail\Address('secondReply@test.com'),
];

$email->addReplyTos(...$replyTos);

// Add attachments
$attachments = [
    '/path/to/my/file.txt',
    '/path/to/other/file.jpg',
];

$email->addAttachments(...$attachments);
```

Sending a templated email:

```php
<?php

// Create a basic email
$from          = new PhpEmail\Address('from@test.com');
$recipients    = [
    new PhpEmail\Address('user@test.com'), 
    new PhpEmail\Address('named@test.com', 'Named User'),
];
$subject       = 'Domain Driven Emails';
$template_data = [
    'first_key'  => 'first value',
    'second_key' => 'second value',
];
$content       = new PhpEmail\Content\TemplatedContent('my_template', $template_data);

$email = new PhpEmail\Email($subject, $content, $from, $recipients);
```
