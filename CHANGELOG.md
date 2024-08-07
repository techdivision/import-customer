# Version 18.0.0

## Features

### PHP 8.1 Compatibility

* Update dependencies
* Add PHP ">=8.1" support
* Remove PHP 7.3 support

# Version 17.1.1

## Bugfixes

* none

## Features

* Add support for optional region address fields 'region_id' and 'region_code'

# Version 17.1.0

## Bugfixes

* none

## Features

* Added strict mode handling for gender value

# Version 17.0.5

## Bugfixes

* Override customer update with existing (website_id and increment_id) or (email and website_id)

## Features

* none

# Version 17.0.4

## Bugfixes

* Use strict mode handling in customer import

## Features

* none

# Version 17.0.3

## Bugfixes

* Fix customer import
  * remove created_at on update
  * add is_active on csv import
  * Format DOB without time
  * Clear columns on update to update only fields that not null. Use `__EMPTY__VALUE__` instead

## Features

* none

# Version 17.0.2

## Bugfixes

* Pac-622: Bugfix- format invalid dob value

## Features

* none

# Version 17.0.1

## Bugfixes

* none

## Features

* Implement black-list.json for customer_entity

# Version 17.0.0

## Bugfixes

* PAC-386: Import customer attributes

## Features

* Refactoring deprecated classes. see https://github.com/techdivision/import-cli-simple/blob/master/UPGRADE-4.0.0.md

# Version 16.0.1

## Bugfixes

* PAC-239: Allow null values for for attribute 'gender' during customer import

## Features

* None

# Version 16.0.0

## Bugfixes

* None

## Features

* Switch to latest techdivision/import 16.* version as dependency

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
