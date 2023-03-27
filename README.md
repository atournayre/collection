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

### Type Assertions

 Method                                                   | Description                                                                 
----------------------------------------------------------|-----------------------------------------------------------------------------
 `TypedCollection::createAsList()`                        | Create a list from an array                                                 
 `TypedCollection::createAsMap()`                         | Create a map from an array                                                  
 `TypedCollectionImmutable::createAsList()`               | Create an immutable list from an array                                      
 `TypedCollectionImmutable::createAsMap()`                | Create an immutable map from an array                                       
 `DecimalValueCollection::fromArray()`                    | Create a collection of DecimalValue from an array                           
 `DecimalValuePrecisionConsistentCollection::fromArray()` | Create a collection of DecimalValue with precision consistent from an array 

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
