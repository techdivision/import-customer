# Version 15.0.0

## Bugfixes

* None

## Features

* Add functionality for dynamic column handling in customer entity

# Version 14.0.1

## Bugfixes

* None

## Features

* Extract dev autoloading

# Version 14.0.0

## Bugfixes

* Add missing method LastEntityIdObserver::getStoreWebsiteIdByCode()
* Remove unnecessary PreLoadEntityIdObserver and replace with LastEntityIdObserver for replace operation

## Features

* None

# Version 13.0.0

## Bugfixes

* Use website code instead of ID to relate customer with website

## Features

* Remove deprecated classes and methods
* Add techdivision/import-cli-simple#216
* Remove unnecessary identifiers from configuration
* Switch to latest techdivision/import 15.* version as dependency

# Version 12.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 14.* version as dependency

# Version 11.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 13.* version as dependency

# Version 10.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 12.* version as dependency

# Version 9.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 11.* version as dependency

# Version 8.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 10.0.* version as dependency

# Version 7.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 9.0.* version as dependency

# Version 6.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 8.0.* version as dependency

# Version 5.0.1

## Bugfixes

* Update default configuration files with listeners

## Features

* None

# Version 5.0.0

## Bugfixes

* None

## Features

* Add composite observers to minimize configuration complexity
* Switch to latest techdivision/import 7.0.* version as dependency
* Make Actions and ActionInterfaces deprecated, replace DI configuration with GenericAction + GenericIdentifierAction

# Version 4.0.0

## Bugfixes

* Fixed issue with invalid address entity IDs for default billing + shipping address
* Add missing methods because of CustomerBunchProcessor implements EavAwareProcessorInterface

## Features

* None

# Version 3.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 6.0.* version as dependency

# Version 2.0.0

## Bugfixes

* Override function AttributeObserverTrait::prepareAttributes() to solve issue with unexpected store_id

## Features

* None

# Version 1.0.0

## Bugfixes

* None

## Features

* Initial Release