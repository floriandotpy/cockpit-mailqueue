cockpit-mailqueue
===

A simple mailqueue to be used with the [Cockpit CMS](http://getcockpit.com/).
Nothing fancy but gets the job done, at least for my needs. The configured
mailer from Cockpit is used, so there is no additional configuration needed.

## Install

```
cd path/to/cockpit/modules/addons
git clone git@github.com:florianletsch/cockpit-mailqueue.git Mailqueue
```

1. Download or clone
2. Place all files in folder `cockpit/modules/addons/Mailqueue`.
3. Open cockpit backend. On success, a mail icon will be added to the main navigation.

## Add emails

Add single email to queue.

```php
cockpit("mailqueue")->add($to, $subject, $message);
```

Add several emails to queue.


```php
$mails = [
    [$to1, $subject1, $message1],
    [$to2, $subject2, $message2],
    ...
];
cockpit("mailqueue")->addBulk($mails);
```

## Process queue

**Process manually via browser.**

1. Open Cockpit backend.
2. Open Mailqueue interface by clicking the envelope icon on the top right.
3. Click *Start processing*.

This will process 5 emails every 5 seconds. Processing stops automatically when finished. ALternatively, just click the *End processing* button.

**Process from code**

If you want automatic processing, just add the following line at whatever point you feel comfortable losing some milliseconds.


```php
// process 10 emails from queue
cockpit("mailqueue")->process();

// process single email from queue
cockpit("mailqueue")->process(1);
```

## Licensed under MIT License

Copyright 2015 Florian Letsch under the MIT license.

The MIT License (MIT)

Copyright (c) 2015 Florian Letsch, http://florianletsch.de

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.