Iridium-library-permissions
===========================

Permissions component. Can work independantly, but best used with Iridium Framework.

This component contains two modules. One is a really simple role-based permission system, the other one is a more complex Access Control Lists system.

The ACL system is not available yet as it is still under development.

## Installation

### Using Composer
First, install [Composer](http://getcomposer.org/ "Composer").
Create a composer.json file at the root of your project. This file must at least contain :
```json
    {
        "require": {
            "awakenweb/iridium-library-permissions": "dev-master"
            }
    }
```
and then run

    ~$ composer install

## RoleBased
### usage

```php
    <?php
    include('path/to/vendor/autoload.php');
    use Iridium\Components\Permissions\RoleBased;
    
    $rb = new RoleBased\RoleBased();
    
    // we add a "reader" role with two permissions
    $role = new RoleBased\Role('reader');
    $role->grant(new RoleBased\Permission('Article.read'));
    $role->grant(new RoleBased\Permission('Comments.read'));
    
    // we store the role in the container
    $rb->addRole($role);
    
    // now we can check if 
    $rb->isAllowed('reader', 'Article.read'); // will return true;
    $rb->isAllowed('reader', 'Article.write'); // will return false;
```
### Storage

As RoleBased is totally storage agnostic, you can simply serialize it to get a ready-to-store string you can put in Memcache, APC or a file.

Unserialize to restore it.
