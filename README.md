# Resource Allocator

This is a simple web app to allocate development resources to a user.

# Installation

Please refer to the [full installation](./documentation/INSTALL.md) documents for how to set up and initially configure Resource Allocator.

# Settings

Take note of the [explanation of settings](./documentation/settings.md) for any optional changes you may wish to make.

# Usage

### Browser

To use, simply browse to the URL of the application (http://localhost:8000 if you configured it per the installation documentation) and log in with the following user/password combination:
- email: **andrew@example.com**
- password: **password**

Upon login in, a user is presented with a list of all allocated resources. They can either request a new resource from that page if one is available (only available resources are listed when requesting a new one) or they can view the details of a specific allocation. Those details would include anything needed to access and utilize that resource; those details may include items such as a file path or user credentials.

### Command Line

##### System Job

There is a system (daemon) job included, which removes any allocated resources that have expired. To run (from the working directory of the code):

```bash
php bin/run.php /cli/clean
```

This would normally be run as a scheduled (cron) task, but can be run manually at any time without detriment.

##### Unit Tests

A basic suite of tests are included. To run from the working directory:

```bash
vendor/bin/phpunit
```

# Code Interfacing

For details on the code interface and help extending and implementing new features, please refer to the [interfacing](./documentation/code_interface.md) documentation.

# Design

Please refer to the [design documentation](./documentation/settings.md) for the philosophy of Resource Allocator, as well as explanation of features and choices made. This includes reasons features are included, what features were left out or not fully implemented, and a "What's Next" list of features to add.