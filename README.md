# ZF2 Feedback module


## Installation

Add this project in your composer.json:

```json
"require": {
    "labcoding/feedback": "~0.0.1"
}
```

Now tell composer to download Domain by running the command:

```bash
$ php composer.phar update
```

OR 

Run command in console

```bash
$ php composer.phar require "labcoding/feedback"
```

#### Post installation

Enabling it in your `application.config.php`file.

```php
<?php
return array(
    'modules' => array(
        // ...
        'LabCoding\Feedback',
    ),
    // ...
);
```

Then you need creating DB table `feedback.'

<pre>
CREATE TABLE IF NOT EXISTS `feedback` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) DEFAULT null,
    `email` VARCHAR(100) DEFAULT null,
    `message` TEXT,
    `answer` TEXT EFAULT NULL,
    `created_dt` DATETIME NOT NULL,
    `updated_dt` DATETIME NOT NULL,
    `status` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
</pre>

And the last, copy to your public folder javascript files: feedback.js & answer.js(they mast located in `js/module/feedback` folder) and include `partial` wear you want to see feedback form

<pre>
<?= $this->partial('partials/feedback-form.phtml'); ?>
</pre>

## Events

`Feedback` events arise when user send feedback or admin sent answer to user.
```php
$eventManager = new EventManager();
$eventManager->getSharedManager()->attach(
     'Feedback',
     FeedbackEvent::EVENT_NEW_FEEDBACK,
     function(FeedbackEvent $e) {
        // Feedback entity
        $entity = $e->getEntity();
        // ...
     },
     $priority
);
```

- `new.feedback` - FeedbackEvent::EVENT_NEW_FEEDBACK - arise after a user left feedback on the site and data save in DB.
- `send.answer` - FeedbackEvent::EVENT_SEND_ANSWER - appear after admin click to "Send" button and data updated in DB.
