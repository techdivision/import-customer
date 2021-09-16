<?php

/**
 * TechDivision\Import\Customer\Observers\CustomerAttributeObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Observers;

use TechDivision\Import\Customer\Utils\ColumnKeys;
use TechDivision\Import\Customer\Utils\MemberNames;
use TechDivision\Import\Observers\AbstractAttributeObserver;
use TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface;

/**
 * Observer that creates/updates the customer's attributes.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class CustomerAttributeObserver extends AbstractAttributeObserver
{

    /**
     * The customer bunch processor instance.
     *
     * @var \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface
     */
    protected $customerBunchProcessor;

    /**
     * Initialize the observer with the passed customer bunch processor instance.
     *
     * @param \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface $customerBunchProcessor The customer bunch processor instance
     */
    public function __construct(CustomerBunchProcessorInterface $customerBunchProcessor)
    {
        $this->customerBunchProcessor = $customerBunchProcessor;
    }

    /**
     * Intializes the existing attributes for the entity with the passed primary key.
     *
     * @param string  $pk      The primary key of the entity to load the attributes for
     * @param integer $storeId The ID of the store view to load the attributes for
     *
     * @return array The entity attributes
     */
    protected function getAttributesByPrimaryKeyAndStoreId($pk, $storeId)
    {
        $this->attributes = $this->getCustomerBunchProcessor()->getCustomerAttributesByEntityId($pk);
    }

    /**
     * Return's the customer bunch processor instance.
     *
     * @return \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface The customer bunch processor instance
     */
    protected function getCustomerBunchProcessor()
    {
        return $this->customerBunchProcessor;
    }

    /**
     * Returns the value(s) of the primary key column(s). As the primary key column can
     * also consist of two columns, the return value can be an array also.
     *
     * @return mixed The primary key value(s)
     */
    protected function getPrimaryKeyValue()
    {

        // initialize the array for the PK values
        $pk = array();

        // prepare the array with the PK values
        foreach ($this->getPrimaryKeyColumnName() as $columName) {
            $pk[] = $this->getValue($columName);
        }

        // return the array with the PK values
        return $pk;
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array|null The prepared attributes
     */
    protected function prepareAttributes()
    {

        // laod the callbacks for the actual attribute code
        $callbacks = $this->getCallbacksByType($this->attributeCode);

        // invoke the pre-cast callbacks
        foreach ($callbacks as $callback) {
            $this->attributeValue = $callback->handle($this);
        }

        // load the ID of the customer that has been created recently
        $lastEntityId = $this->getPrimaryKey();

        // cast the value based on the backend type
        $castedValue = $this->castValueByBackendType($this->backendType, $this->attributeValue);

        // prepare the attribute values
        return $this->initializeEntity(
            array(
                $this->getPrimaryKeyMemberName() => $lastEntityId,
                MemberNames::ATTRIBUTE_ID       => $this->attributeId,
                MemberNames::VALUE              => $castedValue
            )
        );
    }

    /**
     * Return's the PK to create the customer => attribute relation.
     *
     * @return integer The PK to create the relation with
     */
    protected function getPrimaryKey()
    {
        return $this->getSubject()->getLastEntityId();
    }

    /**
     * Return's the PK column name to create the customer => attribute relation.
     *
     * @return string The PK column name
     */
    protected function getPrimaryKeyMemberName()
    {
        return MemberNames::ENTITY_ID;
    }

    /**
     * Return's the column name that contains the primary key.
     *
     * @return string the column name that contains the primary key
     */
    protected function getPrimaryKeyColumnName()
    {
        return array(ColumnKeys::EMAIL, ColumnKeys::WEBSITE);
    }

    /**
     * Queries whether or not the passed PK and store view code has already been processed.
     *
     * @param string $pk            The PK to check been processed
     * @param string $storeViewCode The store view code to check been processed
     *
     * @return boolean TRUE if the PK and store view code has been processed, else FALSE
     */
    protected function storeViewHasBeenProcessed($pk, $storeViewCode)
    {
        return $this->getSubject()->storeViewHasBeenProcessed($pk, $storeViewCode);
    }

    /**
     * Persist's the passed varchar attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistVarcharAttribute($attribute)
    {
        $this->getCustomerBunchProcessor()->persistCustomerVarcharAttribute($attribute);
    }

    /**
     * Persist's the passed integer attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistIntAttribute($attribute)
    {
        $this->getCustomerBunchProcessor()->persistCustomerIntAttribute($attribute);
    }

    /**
     * Persist's the passed decimal attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistDecimalAttribute($attribute)
    {
        $this->getCustomerBunchProcessor()->persistCustomerDecimalAttribute($attribute);
    }

    /**
     * Persist's the passed datetime attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistDatetimeAttribute($attribute)
    {
        $this->getCustomerBunchProcessor()->persistCustomerDatetimeAttribute($attribute);
    }

    /**
     * Persist's the passed text attribute.
     *
     * @param array $attribute The attribute to persist
     *
     * @return void
     */
    protected function persistTextAttribute($attribute)
    {
        $this->getCustomerBunchProcessor()->persistCustomerTextAttribute($attribute);
    }

    /**
     * Delete's the datetime attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteDatetimeAttribute(array $row, $name = null)
    {
        $this->getCustomerBunchProcessor()->deleteCustomerDatetimeAttribute($row, $name);
    }

    /**
     * Delete's the decimal attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteDecimalAttribute(array $row, $name = null)
    {
        $this->getCustomerBunchProcessor()->deleteCustomerDecimalAttribute($row, $name);
    }

    /**
     * Delete's the integer attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteIntAttribute(array $row, $name = null)
    {
        $this->getCustomerBunchProcessor()->deleteCustomerIntAttribute($row, $name);
    }

    /**
     * Delete's the text attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteTextAttribute(array $row, $name = null)
    {
        $this->getCustomerBunchProcessor()->deleteCustomerTextAttribute($row, $name);
    }

    /**
     * Delete's the varchar attribute with the passed value ID.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteVarcharAttribute(array $row, $name = null)
    {
        return $this->getCustomerBunchProcessor()->deleteCustomerVarcharAttribute($row, $name);
    }
}
