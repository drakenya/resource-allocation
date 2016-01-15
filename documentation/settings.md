# Settings

The settings for Resource Allocator are fairly basic and straightforward. For specific setting details, please see below.

All settings are found inside of [lib/settings.php](../lib/settings.php). Snippets for each sub-section will be shown, to indicate relevant lines.

### Display Errors

```php
'displayErrorDetails' => true,
```

Provided by [Slim Framework](http://www.slimframework.com/docs/). Indicates whether or not to display errors back to the client or handle them gracefully.

This would be set to **false** on production instances.

### Template Rendering

```php
'renderer' => [
    'template_path' => __DIR__ . '/../templates/',
],
```

The value of **template_path** is where on disk the display templates are located.

### Logging

```php
// Monolog settings
'logger' => [
    'name' => 'slim-app',
    'path' => __DIR__ . '/../logs/app.log',
],
```

Currently, [Monolog](https://github.com/Seldaek/monolog) is set up as the default logger. It requires the web server to have write access to the [logs/app.log](../logs) file.

# Allocators

```php
// Allocator settings
'allocator_settings' => [
    'MysqlDatabase' => [
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'root',
    ],
    'VirtualMachine' => [
        'base_vm_name' => 'ubuntu-provisioner',
        'vm_path' => '~/VirtualBox VMs/',
    ],
],
```

The **allocator_settings** are a group of settings, pertaining to any added Allocators. Each Allocator type can have it's own key (as does **MysqlDatabase** and **VirtualMachine**), but this is not necessary (as **SqliteDatabase** does not have a settings block). The key used for each allocator is the same as the class name in the [Allocators](../src/Drakenya/ResAll/Allocators) code directory.

##### MySQL

These link to credentials with the ability to create databases, create users, and grant permissions to those newly created databases and users. The **host**, **user**, and **password** refer to those credentials needed.

##### Virtual Machine

The virual machine software is VirtualBox, running on the same host as the web server. The **base_vm_name** is the exact name of a virtual machine to clone when a new resource is requested. The **vm_path** option is the location VirtualBox stores all of its virtual machines on the system.