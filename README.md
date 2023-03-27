Atournayre Collection
================

This library provides a way to manipulate collections.

Installation
------------

Use [Composer] to install the package:

```bash
composer require atournayre/collection
```

Collections
----------

 Method                                                   | Description                                                                 
----------------------------------------------------------|-----------------------------------------------------------------------------
 `TypedCollection::createAsList()`                        | Create a list from an array                                                 
 `TypedCollection::createAsMap()`                         | Create a map from an array                                                  
 `TypedCollectionImmutable::createAsList()`               | Create an immutable list from an array                                      
 `TypedCollectionImmutable::createAsMap()`                | Create an immutable map from an array                                       
 `DecimalValueCollection::fromArray()`                    | Create a collection of DecimalValue from an array                           
 `DecimalValuePrecisionConsistentCollection::fromArray()` | Create a collection of DecimalValue with precision consistent from an array 

Examples
----------

### Typed Collection
```php
// Samples classes
class Person
{
    public function __construct(
        public string $name
    ) {}
}

class People extends TypedCollection
{
    protected static string $type = Person::class;
}
```

```php
// Create collection
$collection = People::createAsList([
    new Person('John'),
]);
$collection[] = new Person('Jack'); // Add item
```

### Typed Collection Immutable
```php
// Samples classes
class Person
{
    public function __construct(
        public string $name
    ) {}
}

class People extends TypedCollectionImmutable
{
    protected static string $type = Person::class;
}
```

```php
// Create collection
$collection = People::createAsList([
    new Person('John'),
]);
$collection[] = new Person('Jack'); // Throws a RuntimeException
```

### Decimal Collection
```php
$collection = DecimalValueCollection::fromArray([
    DecimalValue::create(4.235, 3),
    DecimalValue::fromInt(1),
    DecimalValue::fromString('2'),
    DecimalValue::fromFloat(3.01, 2),
], 2);
$collection[0]->toFloat(); // 4.24
$collection[1]->toFloat(); // 1.00
$collection[2]->toFloat(); // 2.00
$collection[3]->toFloat(); // 3.01
```


Contribute
----------

Contributions to the package are always welcome!

* Report any bugs or issues you find on the [issue tracker].
* You can grab the source code at the package's [Git repository].

License
-------

All contents of this package are licensed under the [MIT license].

[Composer]: https://getcomposer.org

[The Community Contributors]: https://github.com/atournayre/collection/graphs/contributors

[issue tracker]: https://github.com/atournayre/collection/issues

[Git repository]: https://github.com/atournayre/collection

[MIT license]: LICENSE

[webmozart/assert]: https://github.com/webmozart/assert
