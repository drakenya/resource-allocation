# Design Documentation

Resource Allocator is a fully functional PHP application for allocating various development resources. The primary goal was to get a fully-working system from user log in to resource creation/allocation.

Below, please find some explanation of what was picked, what was left out, and why each decision was made.

# Decisions Made and Reasons For

### User Interface

The UI is quite basic, a simple style inherited from the [Slim Framework](http://www.slimframework.com/) default style. It is functional, shows the needed information, and no more. In this way, I was able to concentrate on the backend and the glue of the system instead of the user interface.

### Authentication

The user authentication/authorization package ([Sentinel](https://cartalyst.com/manual/sentinel/2.0)) was added, as that would be a requirement of any real system. All routes/URL's that begin with '/resource/' are protected and require a valid user to access.

There was no user permissions added; however, to do this would not be complex as Sentinel has the capability build in. At that point, only an extra filter to the [routes](../lib/routes.php) would be needed which accounted for the individual permission(s) needed.

### Admin Interface

There is no admin interface currently; instead, time was put into the functionality of the end-to-end system. Notibly lacking are an interface to add/remove resource types and add/modify users. When added, these would go under an /admin/* URL structure and with the help of authentication, be locked to only those with permission to view/edit in the admin area.

To counteract this, and make testing and use of the system quick, seeded database values were added (discussed below).

### Database

The database is a simple SQLite file-system database, to speed development and initial deployments. However, it would not be difficult to use another database of choice (however, it would involve some work, see later).

For database change management, the [Phinx](https://phinx.org/) package was used. Thus, simple database-agnostic database migrations and seeds are possible.

##### Seeding

Hooking on to this, seeds are used to create the test data used in Resource Allocator. One user and three types of resources are present by default when the seeds are applied to the database.

Se later in the document for what the seeded values are.

##### Queries

All queries are hardcoded, but moved to their own Gateway class. In this, it acts as a sort of Model layer of MVC. The Gateway is responsible only for SELECTs and INSERTS (and any other types); no logic should ever be found there. Thus, database-specific Gateways are needed as the SQL can vary between databases. Most notably, this would be the case for datetime functionality as the datetime functions for SQLite are different than MySQL/PostgreSQL.

To alleviate most of this, however, PHP [PDO](http://php.net/manual/en/book.pdo.php) is used. This allows database-independent queries and parametrization (except in the instance of things like datetime). Thus, to switch to another relational database, most of the queries could remain the same and simply work. In this way, a base RelationalDatabaseGateway subclass could be developed to hold all of the common functionality, with the individual Gateways only including the specific parts for that database. However, this was not done for this project.

### Templates

[Twig](http://twig.sensiolabs.org/) was used as the templating engine. While it's true that PHP itself can be considered a templating engine, it was seen as easier and more efficient to include a dedicated templating engine.

The benefits are two-fold. First, it has an easy to read sytax that reads more naturally than when ```<?php ... ?>``` blocks are interspersed. Additionally, Twig is a popular and well-known template system, so other developers will find it easy to pick up and use.

### Unit Tests

There are basic unit tests, that can be run with the command ```vendor/bin/phpunit``` from the base project directory.

While not extensive, they do provide a smoke test to verify that core functionality is maintained and that all routs are currently in operation. In this way, nore only are tests present but the framework for them are fully flushed out for when the complexity of the program is advanced.

##### Mockery

Resource Allocator uses [Mockery](https://github.com/padraic/mockery) to mock objects and classes within the tests. This allows easy and extensive testing, especially when the each piece and class in the code has an individual concern.

### Documentation

The documentation was deemed important for this project. Not only because it was meant as an example, but mostly because along with a simple interface it allows other developers (or designers) to extend, modify, and understand the code with relative ease.

Additionally, existing documentation makes it easier to keep it up to date and continue writing it. Without it, it can be put off as something to add later; later, this turns into never because of the scope of the work that's been constantly put off. Instead, it's simple to extend the documentation with each modification done that necessitates it. (This same principle can also apply to unit testing.)

# Decision Overview

### Included

* A fully-functional program, based on Slim and added components.
* Component glue. Instead of using Laravel or Symfony, Slim was used to be able to create the individual glue pieces. Not only did this allow for customization, but it let me work on some of the code points I find most interesting. Instead of re-implementing code that's been done before, I can put pieces together (and create, adapt, and mofiy as necessary) to make something more functional than the sum of the pieces.
* User authentication. This is vital for many systems, and much easier to put in place from the beginning. Even though authorization will need added later, with the frame work and backend database tables in place it will be a simple matter to add.
* Example resources. Setting up three different resources (a file on the file system, a virtual machine copied from an existing one, and manipulation of a database) allows showing off a breadth of knowledge. It also provides examples of what is possible, and the best way to isolate the very specific implementations of Resources.
* Unit tests. Even though they are basic, they do help to smoke test and ensure that basic functionality is present. Moreover, it's much easier to add existing unit tests than start from scratch; the framework is finished and confirmed working, so adding to it requires a minimum of effort.
* Documentation. The documentation not only allows others to see how the individual parts work but it allows me to extend and adapt when coming back to the program. Settings, interfaces, and general patterns all help to understand what specific parts perform what duties. With this knowledge, extending the program is simplified (for example, knowing how to add user authorization or new Resources).
* Daemon/system job. This allowed for finding a way to hook the framework into the commandline, as well as demonstrating a need for jobs to control background tasks. On a production system, these could be hooked up to cron and run on a regular basis (or a queueing/job server).

### Excluded

* User interface. I would much rather work on backend code (or glue, or system support) than design interfaces, and this is reflected in the basic nature of the UI. However, it is functional (and could be improved with a Bootstrap-like template) and allows for another to easily extend and improve it without touching the code. In that way, the [templates](../templates/) could be replaced wholesale and nothing from the code would need changed.
* More complete frameworks. Laravel or Symphony would have provided more tools out of the box, with less integration work, but leaving those out allowed for showing off more glue and backend skills. However, it would be worth considering a more fully featured framework for other projects, depending on the specific needs of the program.
* User authorization and an admin interface. Ideally, there would be an admin interface for editing users and Resources. This part of the site would be protected by permissions. However, it was left out as for a simple site, it was not needed to get it functional and initial functionality was deemed more important and a better use of limited time. It should be one of the first things added, though.
* More robust database solution. SQLite works very well for prototyping and mocking a site, but it is probably not the best to use for a production application. However, it was used for this to allow for rapid development. When setting up in prod, though, a PostgreSQL database would be used if given the choice. Additionally, SQLite has specific datetime functions that are non-standard, which would need replaced. However, to get started this was deemed acceptable (and are extracted out to a Gateway so they are also isolated and easily replaced).
* More robust web server. In the same manner, Apache (or Nginx) would be used instead of the built-in PHP web server. However, not only was it easier and quicker to begin development but it allows for easier set up for others when viewing the code and application. Also, it would not disturb other web server setups already in existance (modifying ```/etc/hosts``` files and ```/etc/apache/sites-{enabled,available}/``` directories).

# Seeds

An overview of the default seed values, provided by the [UserSeeder](../data/seeds/UserSeeder.php) and [ResourceSeeder](../data/seeds/ResourceSeeder.php).

### Users

A single user is added, but more can be if required following the same pattern. The credentials for the base user are:

* username: **andrew@example.com**
* password: **password**

### Resources

There are three resources set up by default. One, SQLite, can be used on any system with the required modules installed. The other two, MySQL and VirtualBox, need additional set up (see the [install documentation](./INSTALL.md) for details).

##### SQLite

The SQLite resource creates a simple SQLite database in the system-defined temporary file system. On deallocation, the file is destroyed.

##### MySQL

Credentials are needed for a MySQL user that has various CREATE privileges. In this way, the Allocator can create a new database with its own user/password to access. On deallocation, that database and user are removed.

##### VirtualBox

A VirtualBox virtual machine is able to be cloned upon request. Upon deallocation, the aforementioned virtual machine is removed from both the file system and VirtualBox.