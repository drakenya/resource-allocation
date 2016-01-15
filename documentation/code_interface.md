# Code Interface

The following documents key code features, Interfaces, and patterns used within Resource Allocator.

# Actions

Actions are the glue that runs Resource Allocator. In order to have light controllers and light models (Gateways), Actions contain the logic to make everything run.

In this way, basic actions can be shared; this is especially useful when sharing commands between the web interface and the command line interface. Instead of code duplication inside of the controllers, the bulk of the code lives in an Action and needs only to be called from outside.

# Allocators

### Interface

```php
interface AllocatorInterface {
    /**
     * Actually create a new resource
     *
     * @return array Details about new resource
     */
    public function allocate();
    /**
     * Remove existing resource from the pool/system
     *
     * @param array $data
     */
    public function deallocate($data);
}
```

### Philosophy

The basics of an Allocator are that it can do two things, allocate or deallocate a resource. There are no limits to what can be defined as a resource. Because of this, it will be typical that Allocators have lots of code that deals directly with file systems, databases, or other external resources. By defining an Allocator to be very low-level, this code will be isolated and will not impact any other bits of the system. Additionally, an Allocator should not perform any logic (other than possibly allowing simple options), that logic should have already been handled by the time execution got to an Allocator.

### Settings

Each Allocator can have its own settings in [lib/settings.php](../lib/settings.php) inside of the **allocator_settings** block. The name of the file, class, and settings key are consistent. Inside the specific settings block, there are no limits or assumed defaults for any values. In that way, each individual Allocator can determine the specific settings and default values needed.

# Controllers

Controllers handle receiving the request and preparing/sending the response. This can be either for the web or command line. Otherwise, they remain lightweight with any heavy lifting passed off to Actions.

### Jugt/Slim

There is one external component not loaded by composer, and that is a Controller base. The basis for the code comes from the [juliangut/slim-controller](https://github.com/juliangut/slim-controller) package. It was not included because it did not work on current versions of Slim 3. However, the copyright notice was retained.

In short, it allows the controller to access services from the [container](http://www.slimframework.com/docs/concepts/di.html) using magic methods, such as ```$this->container_name``` or ```$this->get('container_name')```.

# Gateways

Gateways are the level that interfaces directly with the database (or other data store). They only thing they should contain are the direct queries, no logic. In this way, it's easy to extend the program to work with other data stores.

### Interfaces

An interface is provided for each type of Gateway (for example, the [ResourceInterface](../src/Drakenya/ResAll/Gateways/ResourceInterface.php)). This simply defines the expected functionality and leaves it up to the individual data store to figure out the best, most efficient way to accomplish the actions.