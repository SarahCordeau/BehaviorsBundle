Description
===========

This bundle allow to 
- add dynamic comment on object passed in reference,
- reply on a comment,
- show comments list for object passed in reference,
- show statistics of comments.

Installation
============

Step 1: Download the Bundle
---------------------------
Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require sco/behaviors-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new \Sco\BehaviorsBundle\ScoBehaviorsBundle(),
        ];

        // ...
    }

    // ...
}
```

Install assets
```console
$ php bin/console assets:install web --symlink
```

Update doctrine database
```console
$ php bin/console doctrine:schema:update --force
```


Step 3: Configuration
---------------------
```yaml
# app/config/config.yml

parameters:
    sco.behaviors_bundle.commentable_subscriber.user_entity: AppBundle\Entity\User # ~ (default value null)
    sco.behaviors_bundle.reply_limit:  # ~ (null) value is 1, default 0: limit the number of descendants allowed to respond

    
sco_behaviors_bundle:
    commentable: true # false, ~ (null) value is false
```

```yaml
# app/config/routing.yml
sco_behaviors_bundle:
    resource: "@ScoBehaviorsBundle/Resources/config/routing.yml"
    prefix:   /
```

Usage
-----

```
## To render comment form
{{ render(controller('ScoBehaviorsBundle:Comment:form', {'object': your_object})) }}
```

```
## To render list for one object
{{ render(controller('ScoBehaviorsBundle:Comment:list', {'object': your_object})) }}
```

```
## To render statistics
{{ render(controller('ScoBehaviorsBundle:Comment:statistic', {'filter': filter, 'order': order})) }}  
## Allowed 
$filter = 'year' // or 'month' default 'year';
// or
$order = 'desc' // or 'asc' default 'desc';
```
