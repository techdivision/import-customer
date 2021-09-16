<?php

/**
 * TechDivision\Import\Customer\Subjects\AbstractCustomerSubject
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Subjects;

use TechDivision\Import\Customer\Utils\MemberNames;
use TechDivision\Import\Subjects\AbstractEavSubject;
use TechDivision\Import\Subjects\EntitySubjectInterface;
use TechDivision\Import\Customer\Utils\ConfigurationKeys;
use TechDivision\Import\Customer\Utils\RegistryKeys;
use TechDivision\Import\Utils\FrontendInputTypes;

/**
 * The abstract customer subject implementation that provides basic customer
 * handling business logic.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
abstract class AbstractCustomerSubject extends AbstractEavSubject implements EntitySubjectInterface
{

    /**
     * The ID of the customer that has been created recently.
     *
     * @var string
     */
    protected $lastEntityId;

    /**
     * The identifier (email + website) of the customer that has been created recently.
     *
     * @var string
     */
    protected $lastIdentifier;

    /**
     * The Magento 2 configuration.
     *
     * @var array
     */
    protected $coreConfigData;

    /**
     * The mapping for the mail webseite code to the created entity IDs.
     *
     * @var array
     */
    protected $customerIdentifierEntityIdMapping = array();

    /**
     * The available store websites.
     *
     * @var array
     */
    protected $storeWebsites = array();


    /**
     * The default mappings for the user defined attributes, based on the attributes frontend input type.
     *
     * @var array
     */
    protected $defaultFrontendInputCallbackMappings = array(
        FrontendInputTypes::SELECT      => array('import_customer.callback.select'),
        FrontendInputTypes::MULTISELECT => array('import_customer.callback.multiselect'),
        FrontendInputTypes::BOOLEAN     => array('import_customer.callback.boolean')
    );

    /**
     * Sets the customer identifier of the last imported customer.
     *
     * @param array $identifier The unique customer identifier
     *
     * @return void
     */
    public function setLastIdentifier(array $identifier)
    {
        $this->lastIdentifier = $identifier;
    }

    /**
     * Return's the SKU of the last imported customer.
     *
     * @return string|null The SKU
     */
    public function getLastIdentifier()
    {
        return $this->lastIdentifier;
    }

    /**
     * Set's the ID of the customer that has been created recently.
     *
     * @param string $lastEntityId The entity ID
     *
     * @return void
     */
    public function setLastEntityId($lastEntityId)
    {
        $this->lastEntityId = $lastEntityId;
    }

    /**
     * Return's the ID of the customer that has been created recently.
     *
     * @return string The entity Id
     */
    public function getLastEntityId()
    {
        return $this->lastEntityId;
    }

    /**
     * Queries whether or not the customer with the passed identifier has already been processed.
     *
     * @param array $identifier The customer identifier to check
     *
     * @return boolean TRUE if the customer has been processed, else FALSE
     */
    public function hasBeenProcessed(array $identifier)
    {

        // explode the identifier (we need email + website code)
        list ($email, $website) = $identifier;

        // query whether or not the entity ID has already been mapped
        return isset($this->customerIdentifierEntityIdMapping[$email][$website]);
    }

    /**
     * Queries whether or not the passed PK and store view code has already been processed.
     *
     * @param string $pk            The PK to check been processed
     * @param string $storeViewCode The store view code to check been processed
     *
     * @return boolean TRUE if the PK and store view code has been processed, else FALSE
     */
    public function storeViewHasBeenProcessed($pk, $storeViewCode)
    {
        return false;
    }

    /**
     * Add the passed mail address/website code => entity ID mapping.
     *
     * @param string $email   The mail address of the customer
     * @param string $website The website code the customer is bound to
     *
     * @return void
     */
    public function addCustomerIdentifierEntityIdMapping($email, $website)
    {
        $this->customerIdentifierEntityIdMapping[$email][$website] = $this->getLastEntityId();
    }

    /**
     * Intializes the previously loaded global data for exactly one bunch.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function setUp($serial)
    {

        // load the status of the actual import
        $status = $this->getRegistryProcessor()->getAttribute(RegistryKeys::STATUS);

        // load the global data we've prepared initially
        $this->storeWebsites =  $status[RegistryKeys::GLOBAL_DATA][RegistryKeys::STORE_WEBSITES];

        // invoke the parent method
        parent::setUp($serial);
    }

    /**
     * Clean up the global data after importing the bunch.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function tearDown($serial)
    {

        // load the registry processor
        $registryProcessor = $this->getRegistryProcessor();

        // update the status
        $registryProcessor->mergeAttributesRecursive(
            RegistryKeys::STATUS,
            array(
                RegistryKeys::CUSTOMER_IDENTIFIER_ENTITY_ID_MAPPING => $this->customerIdentifierEntityIdMapping,
            )
        );

        // invoke the parent method
        parent::tearDown($serial);
    }

    /**
     * Return's the store ID of the actual row, or of the default store
     * if no store view code is set in the CSV file.
     *
     * @param string|null $default The default store view code to use, if no store view code is set in the CSV file
     *
     * @return integer The ID of the actual store
     * @throws \Exception Is thrown, if the store with the actual code is not available
     */
    public function getRowStoreId($default = null)
    {

        // initialize the default store view code, if not passed
        if ($default == null) {
            $defaultStore = $this->getDefaultStore();
            $default = $defaultStore[MemberNames::CODE];
        }

        // load the store view code to create the customer/attributes for
        $storeViewCode = $this->getStoreViewCode($default);

        // query whether or not, the requested store is available
        if (isset($this->stores[$storeViewCode])) {
            return (integer) $this->stores[$storeViewCode][MemberNames::STORE_ID];
        }

        // throw an exception, if not
        throw new \Exception(
            $this->appendExceptionSuffix(
                sprintf('Found invalid store view code %s', $storeViewCode)
            )
        );
    }

    /**
     * Merge the columns from the configuration with all image type columns to define which
     * columns should be cleaned-up.
     *
     * @return array The columns that has to be cleaned-up
     */
    public function getCleanUpColumns()
    {
        return $this->getConfiguration()->getParam(ConfigurationKeys::CLEAN_UP_EMPTY_COLUMNS);
    }

    /**
     * Return's the store website for the passed code.
     *
     * @param string $code The code of the store website to return the ID for
     *
     * @return integer The store website ID
     * @throws \Exception Is thrown, if the store website with the requested code is not available
     */
    public function getStoreWebsiteIdByCode($code)
    {

        // query whether or not, the requested store website is available
        if (isset($this->storeWebsites[$code])) {
            return (integer) $this->storeWebsites[$code][MemberNames::WEBSITE_ID];
        }

        // throw an exception, if not
        throw new \Exception(
            $this->appendExceptionSuffix(
                sprintf('Found invalid website code %s', $code)
            )
        );
    }
}
