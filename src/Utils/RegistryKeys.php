<?php

/**
 * TechDivision\Import\Customer\Utils\RegistryKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Utils;

/**
 * Utility class containing the unique registry keys.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class RegistryKeys extends \TechDivision\Import\Utils\RegistryKeys
{

    /**
     * Key for the registry entry containing the country Regions.
     *
     * @var string
     */
    const COUNTRY_REGIONS = 'countryRegions';

    /**
     * Key for the registry entry containing the preloaded SKU => entity ID mapping.
     *
     * @var string
     */
    const PRE_LOADED_ENTITY_IDS = 'preLoadedEntityIds';

    /**
     * Key for the registry entry containing the customer identifier => entity ID mapping.
     *
     * @var string
     */
    const CUSTOMER_IDENTIFIER_ENTITY_ID_MAPPING = 'customerIdentifierEntityIdMapping';
}
