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

Enabling it in your `application.config.php` file.

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

OR run console command:

```bash
$ php public/index.php feedback init
```

And the last, copy to your public folder javascript files: feedback.jfeedbacker.js(they mast located in `js/module/feedback` feedbackand include `partial` wear you want to see feedback ffeedbacke>
<?= $this->partial('partials/feedback-form.phtml'); ?>
</pre>

## Events

`Feedback` events arise when user send feedback ofeedbacksent answer to user.
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

- `FeedbackEvent::EVENT_NEW_FEEDBACK` - `new.feedback` - arise after a user left feedback ofeedbackte and data save in DB.
- `FeedbackEvent::EVENT_SEND_ANSWER` - `send.answer` - appear after admin click to "Send" button and data updated in DB.

## Add new field to feedback `(form, table, entity)`

1 - Create in your project module Feedback

2 - Add to config new entity map structure:

<pre>
    'entity_map' => [
        'Feedback' => [
            'entityClass' => \Feedback\Domain\Feedback::class,
            'table' => 'feedback',
            'primaryKey' => 'id',
            'columnsAsAttributesMap' => [
                'id' => 'id',
                'name' => 'name',
                'phone' => 'phone', // it is new field
                'email' => 'email',
                'message' => 'message',
                'answer' => 'answer',
                'created_dt' => 'createdDt',
                'updated_dt' => 'updatedDt',
                'status' => 'status',
            ],
            'criteriaMap' => [
                'id' => 'id_equalTo',
            ]
        ],
    ]
</pre>

3 - Create new Feedback entity file, extends it from `\LabCoding\Feedback\Domain\Feedback`, and add new property:

```php
<?php

class Feedback extends \LabCoding\Feedback\Domain\Feedback
{

    protected $phone;

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
```

4 - Crete new input filter, and add it to service manager:

```php
    'service_manager' => array(
        'invokables' => array(
            'LabCoding\Feedback\InputFilter\SendInputFilter' => SendInputFilter::class,
        )
    )
```

5 - At the last add new field to feedback form
