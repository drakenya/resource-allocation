# Requirements

The following are the requirements to run.  Note that the optional packages and programs are just that; however, note that some functionality of the example set up will not work without those optional programs installed and configured.

It is assumed that the user is running Ubuntu 12.04. The versions of this software are tested for that system; however, it is highly likely that the set up steps will work just as well for newer versions of Ubuntu (or, really, a derivative of it; it will just be up to the user to determine the exact commands to run).

For installation and configuration, bash commands will be given as necessary to allow for easier setting up.

### Packages
- PHP v5.5
- composer

### PHP modules
- sqlite (php5-sqlite)


### Optioal Packages
- MySQL (mysql-server, mysql-client, php5-mysql)


### Optional Programs
- VirtualBox (with installed VM)

# Installation

### PHP

Resource Allocator will require PHP v5.5 with the SQLite extension and optionally the MySQL extension.  While a stand-alone web server could be used, we will demonstrate using the build-in PHP web server.

```bash
# Required, for PHP v5.5
sudo apt-get install php5-common php5-cli php5-sqlite

# optional, for MySQL integration
sudo apt-get install mysql-server, mysql-client, php5-mysql
```

### Resource Allocator

Intalling Resource Allocator is simply fetching the code from GitHub

```bash
git clone https://github.com/drakenya/resource-allocation.git
```

**Note:** *From here on out, it will be assumed that all commands are run from the main code directory.*
```bash
cd resource-allocation
```

### Composer

Composer is the package manager for PHP. Resource Allocator uses a number of components, and composwer allows easy installation of these external dependencies.

```bash
# Install comopser (to composer.phar, in the current directory)
curl -sS https://getcomposer.org/installer | php

# Run composer, to install needed dependencies
./composer.phar install
```

### Configuration

There are two optional settings, one for MySQL and one for VirtualBox.  Both are configured in the same file, [lib/settings.php](../lib/settings.php), under the following block:

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

The configuration settings are listed as **key** => *value* stores. When adjusting for your system, simply set the *value* from the default given.

##### MySQL

The **host**, **user**, and **password** options are for a MySQL server and user account where that user has permissions to create new databases, create new users, and grant those users permissions on the new databases.

If installing on a stock Ubuntu machine, simply use the same password you set up when creating the root account during installation.

##### VirtualBox

The app has the capability to clone an existing virtual machine loaded into VirtualBox. The *base_vm_name* option is the name of any virtual machine in VirtualBox that can be cloned (exact name required, it's case-sensitive).

**Note:** *For testing, it's possible (and fairly quick) to install VirtualBox, create a simple Ubuntu server virtual machine, and use that for the cloning. If doing this, install the server .iso, set up a user account, log in once and power the machine down. That will be enough to test the integration.*

# Use

First, we'll need to create and seed the database; after that, simply start the web server.

### Database and Seeding

Setting the database up is simple, as Resource Allocator uses a database migration system to track all changes. To set up for the first time, we'll run the migrations to create our tables and then add some dummy data.

**Note:** *The following commands require that the user running the web server has write and modify access to the [data/](../data) directory. We will be creating a new SQLite file in this directory.*

```bash
# Note that this command will alert that **No migrations to rollback**. This is because we have not yet initialized the database. However, this command is given for completeness, so that these three command can be run in sequence to reset the database if necessary.
php vendor/bin/phinx rollback -t 0

php vendor/bin/phinx migrate

# Seed the database with some dummy data
vendor/bin/phinx seed:run
```

### Server

Use the included PHP web server. One the command is issued, the terminal will hang and display any output from the server (so if more commands are to be run, a separate terminal will need opened. Don't forget to cd back to the code directory).

```bash
php -S localhost:8000 -t public public/index.php
```

You can now browse to **http://localhost:8000** in the browser of your choice to access the system. Use the email/password combination of **andrew@example.com**/**password** to do so, to get started.