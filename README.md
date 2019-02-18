Sto Commentable bundle usage
============================

This document describe how to use the ScoBehaviorsBundle

Description
-----------
This bundle allow to 
- add dynamic comment on object passed in reference,
- reply on a comment,
- show comments list for object passed in reference,
- show statistics of comments.

Integration
-----------

````
# AppKernel.php
public function registerBundles()
{
    $bundles = [
        //....
        new \Sco\BehaviorsBundle\ScoBehaviorsBundle()
    ];
}
````

````
# update doctrine database
php bin/console doctrine:schema:update --force
````

Configuration
-------------

````
# app/config/config.yml

parameters:
    # For example: PATH_TO_YOUR_USER_ENTITY = AppBundle\Entity\User
    sco.behaviors_bundle.commentable_subscriber.user_entity: PATH_TO_YOUR_USER_ENTITY # ~ (default value null)
    sco.behaviors_bundle.reply_limit:  # ~ (null) value is 1, default 1: limit the number of descendants allowed to respond

    
sco_behaviors_bundle:
    commentable: true # false, ~ (null) value is false
````

````
# app/config/routing.yml
sco_behaviors_bundle:
    resource: "@ScoBehaviorsBundle/Resources/config/routing.yml"
    prefix:   /
````

Usage
-----

````
## To render comment form
{{ render(controller('ScoBehaviorsBundle:Comment:form', {'object': your_object})) }}
````

````
## To render list for one object
{{ render(controller('ScoBehaviorsBundle:Comment:list', {'object': your_object})) }}
````

````
## To render statistics
{{ render(controller('ScoBehaviorsBundle:Comment:statistic', {'filter': filter, 'order': order})) }}  
## Allowed 
$filter = 'year' // or 'month' default 'year';
// or
$order = 'desc' // or 'asc' default 'desc';
````
