<?php

/**
 * TechDivision\Import\Customer\Services\CustomerBunchProcessor
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Services;

use TechDivision\Import\Actions\ActionInterface;
use TechDivision\Import\Connection\ConnectionInterface;
use TechDivision\Import\Repositories\EavAttributeRepositoryInterface;
use TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface;
use TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface;
use TechDivision\Import\Customer\Assemblers\CustomerAttributeAssemblerInterface;
use TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface;

/**
 * The customer bunch processor implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class CustomerBunchProcessor implements CustomerBunchProcessorInterface
{

    /**
     * A PDO connection initialized with the values from the Doctrine EntityManager.
     *
     * @var \TechDivision\Import\Connection\ConnectionInterface
     */
    protected $connection;

    /**
     * The repository to access EAV attribute option values.
     *
     * @var \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface
     */
    protected $eavAttributeOptionValueRepository;

    /**
     * The repository to access customer data.
     *
     * @var \TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * The repository to access EAV attributes.
     *
     * @var \TechDivision\Import\Repositories\EavAttributeRepositoryInterface
     */
    protected $eavAttributeRepository;

    /**
     * The repository to access EAV attributes.
     *
     * @var \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface
     */
    protected $eavEntityTypeRepository;

    /**
     * The action for customer CRUD methods.
     *
     * @var \TechDivision\Import\Actions\ActionInterface
     */
    protected $customerAction;

    /**
     * The action for customer varchar attribute CRUD methods.
     *
     * @var \TechDivision\Import\Actions\ActionInterface
     */
    protected $customerVarcharAction;

    /**
     * The action for customer text attribute CRUD methods.
     *
     * @var \TechDivision\Import\Actions\ActionInterface
     */
    protected $customerTextAction;

    /**
     * The action for customer int attribute CRUD methods.
     *
     * @var \TechDivision\Import\Actions\ActionInterface
     */
    protected $customerIntAction;

    /**
     * The action for customer decimal attribute CRUD methods.
     *
     * @var \TechDivision\Import\Actions\ActionInterface
     */
    protected $customerDecimalAction;

    /**
     * The action for customer datetime attribute CRUD methods.
     *
     * @var \TechDivision\Import\Actions\ActionInterface
     */
    protected $customerDatetimeAction;

    /**
     * The assembler to load the customer attributes with.
     *
     * @var \TechDivision\Import\Customer\Assemblers\CustomerAttributeAssemblerInterface
     */
    protected $customerAttributeAssembler;

    /**
     * Initialize the processor with the necessary assembler and repository instances.
     *
     * @param \TechDivision\Import\Connection\ConnectionInterface                          $connection                        The connection to use
     * @param \TechDivision\Import\Customer\Assemblers\CustomerAttributeAssemblerInterface $customerAttributeAssembler        The customer attribute assembler to use
     * @param \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface $eavAttributeOptionValueRepository The EAV attribute option value repository to use
     * @param \TechDivision\Import\Repositories\EavAttributeRepositoryInterface            $eavAttributeRepository            The EAV attribute repository to use
     * @param \TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface       $customerRepository                The customer repository to use
     * @param \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface           $eavEntityTypeRepository           The EAV entity type repository to use
     * @param \TechDivision\Import\Actions\ActionInterface                                 $customerAction                    The customer action to use
     * @param \TechDivision\Import\Actions\ActionInterface                                 $customerDatetimeAction            The customer datetime action to use
     * @param \TechDivision\Import\Actions\ActionInterface                                 $customerDecimalAction             The customer decimal action to use
     * @param \TechDivision\Import\Actions\ActionInterface                                 $customerIntAction                 The customer integer action to use
     * @param \TechDivision\Import\Actions\ActionInterface                                 $customerTextAction                The customer text action to use
     * @param \TechDivision\Import\Actions\ActionInterface                                 $customerVarcharAction             The customer varchar action to use
     */
    public function __construct(
        ConnectionInterface $connection,
        CustomerAttributeAssemblerInterface $customerAttributeAssembler,
        EavAttributeOptionValueRepositoryInterface $eavAttributeOptionValueRepository,
        EavAttributeRepositoryInterface $eavAttributeRepository,
        CustomerRepositoryInterface $customerRepository,
        EavEntityTypeRepositoryInterface $eavEntityTypeRepository,
        ActionInterface $customerAction,
        ActionInterface $customerDatetimeAction,
        ActionInterface $customerDecimalAction,
        ActionInterface $customerIntAction,
        ActionInterface $customerTextAction,
        ActionInterface $customerVarcharAction
    ) {
        $this->setConnection($connection);
        $this->setCustomerAttributeAssembler($customerAttributeAssembler);
        $this->setEavAttributeOptionValueRepository($eavAttributeOptionValueRepository);
        $this->setEavAttributeRepository($eavAttributeRepository);
        $this->setCustomerRepository($customerRepository);
        $this->setCustomerAction($customerAction);
        $this->setCustomerDatetimeAction($customerDatetimeAction);
        $this->setCustomerDecimalAction($customerDecimalAction);
        $this->setCustomerIntAction($customerIntAction);
        $this->setCustomerTextAction($customerTextAction);
        $this->setCustomerVarcharAction($customerVarcharAction);
    }

    /**
     * Set's the passed connection.
     *
     * @param \TechDivision\Import\Connection\ConnectionInterface $connection The connection to set
     *
     * @return void
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return's the connection.
     *
     * @return \TechDivision\Import\Connection\ConnectionInterface The connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Turns off autocommit mode. While autocommit mode is turned off, changes made to the database via the PDO
     * object instance are not committed until you end the transaction by calling CustomerProcessor::commit().
     * Calling CustomerProcessor::rollBack() will roll back all changes to the database and return the connection
     * to autocommit mode.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commits a transaction, returning the database connection to autocommit mode until the next call to
     * CustomerProcessor::beginTransaction() starts a new transaction.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.commit.php
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Rolls back the current transaction, as initiated by CustomerProcessor::beginTransaction().
     *
     * If the database was set to autocommit mode, this function will restore autocommit mode after it has
     * rolled back the transaction.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition
     * language (DDL) statement such as DROP TABLE or CREATE TABLE is issued within a transaction. The implicit
     * COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.rollback.php
     */
    public function rollBack()
    {
        return $this->connection->rollBack();
    }

    /**
     * Set's the repository to load the customers with.
     *
     * @param \TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface $customerRepository The repository instance
     *
     * @return void
     */
    public function setCustomerRepository(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Return's the repository to load the customers with.
     *
     * @return \TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface The repository instance
     */
    public function getCustomerRepository()
    {
        return $this->customerRepository;
    }

    /**
     * Set's the action with the customer CRUD methods.
     *
     * @param \TechDivision\Import\Actions\ActionInterface $customerAction The action with the customer CRUD methods
     *
     * @return void
     */
    public function setCustomerAction(ActionInterface $customerAction)
    {
        $this->customerAction = $customerAction;
    }

    /**
     * Return's the action with the customer CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerAction()
    {
        return $this->customerAction;
    }

    /**
     * Set's the action with the customer varchar attribute CRUD methods.
     *
     * @param \TechDivision\Import\Actions\ActionInterface $customerVarcharAction The action with the customer varchar attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerVarcharAction(ActionInterface $customerVarcharAction)
    {
        $this->customerVarcharAction = $customerVarcharAction;
    }

    /**
     * Return's the action with the customer varchar attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerVarcharAction()
    {
        return $this->customerVarcharAction;
    }

    /**
     * Set's the action with the customer text attribute CRUD methods.
     *
     * @param \TechDivision\Import\Actions\ActionInterface $customerTextAction The action with the customer text attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerTextAction(ActionInterface $customerTextAction)
    {
        $this->customerTextAction = $customerTextAction;
    }

    /**
     * Return's the action with the customer text attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerTextAction()
    {
        return $this->customerTextAction;
    }

    /**
     * Set's the action with the customer int attribute CRUD methods.
     *
     * @param \TechDivision\Import\Actions\ActionInterface $customerIntAction The action with the customer int attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerIntAction(ActionInterface $customerIntAction)
    {
        $this->customerIntAction = $customerIntAction;
    }

    /**
     * Return's the action with the customer int attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerIntAction()
    {
        return $this->customerIntAction;
    }

    /**
     * Set's the action with the customer decimal attribute CRUD methods.
     *
     * @param \TechDivision\Import\Actions\ActionInterface $customerDecimalAction The action with the customer decimal attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerDecimalAction(ActionInterface $customerDecimalAction)
    {
        $this->customerDecimalAction = $customerDecimalAction;
    }

    /**
     * Return's the action with the customer decimal attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerDecimalAction()
    {
        return $this->customerDecimalAction;
    }

    /**
     * Set's the action with the customer datetime attribute CRUD methods.
     *
     * @param \TechDivision\Import\Actions\ActionInterface $customerDatetimeAction The action with the customer datetime attriute CRUD methods
     *
     * @return void
     */
    public function setCustomerDatetimeAction(ActionInterface $customerDatetimeAction)
    {
        $this->customerDatetimeAction = $customerDatetimeAction;
    }

    /**
     * Return's the action with the customer datetime attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerDatetimeAction()
    {
        return $this->customerDatetimeAction;
    }

    /**
     * Set's the repository to access EAV attribute option values.
     *
     * @param \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface $eavAttributeOptionValueRepository The repository to access EAV attribute option values
     *
     * @return void
     */
    public function setEavAttributeOptionValueRepository(EavAttributeOptionValueRepositoryInterface $eavAttributeOptionValueRepository)
    {
        $this->eavAttributeOptionValueRepository = $eavAttributeOptionValueRepository;
    }

    /**
     * Return's the repository to access EAV attribute option values.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface The repository instance
     */
    public function getEavAttributeOptionValueRepository()
    {
        return $this->eavAttributeOptionValueRepository;
    }

    /**
     * Set's the repository to access EAV attributes.
     *
     * @param \TechDivision\Import\Repositories\EavAttributeRepositoryInterface $eavAttributeRepository The repository to access EAV attributes
     *
     * @return void
     */
    public function setEavAttributeRepository(EavAttributeRepositoryInterface $eavAttributeRepository)
    {
        $this->eavAttributeRepository = $eavAttributeRepository;
    }

    /**
     * Return's the repository to access EAV attributes.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeRepositoryInterface The repository instance
     */
    public function getEavAttributeRepository()
    {
        return $this->eavAttributeRepository;
    }

    /**
     * Set's the repository to access EAV entity types.
     *
     * @param \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface $eavEntityTypeRepository The repository to access EAV entity types
     *
     * @return void
     */
    public function setEavEntityTypeRepository(EavEntityTypeRepositoryInterface $eavEntityTypeRepository)
    {
        $this->eavEntityTypeRepository = $eavEntityTypeRepository;
    }

    /**
     * Return's the repository to access EAV entity types.
     *
     * @return \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface The repository instance
     */
    public function getEavEntityTypeRepository()
    {
        return $this->eavAttributeRepository;
    }

    /**
     * Set's the assembler to load the customer attributes with.
     *
     * @param \TechDivision\Import\Customer\Assemblers\CustomerAttributeAssemblerInterface $customerAttributeAssembler The assembler instance
     *
     * @return void
     */
    public function setCustomerAttributeAssembler(CustomerAttributeAssemblerInterface $customerAttributeAssembler)
    {
        $this->customerAttributeAssembler = $customerAttributeAssembler;
    }

    /**
     * Return's the assembler to load the customer attributes with.
     *
     * @return \TechDivision\Import\Customer\Assemblers\CustomerAttributeAssemblerInterface The assembler instance
     */
    public function getCustomerAttributeAssembler()
    {
        return $this->customerAttributeAssembler;
    }

    /**
     * Return's an array with the available EAV attributes for the passed is user defined flag.
     *
     * @param integer $isUserDefined The flag itself
     *
     * @return array The array with the EAV attributes matching the passed flag
     */
    public function getEavAttributeByIsUserDefined($isUserDefined = 1)
    {
        return $this->getEavAttributeRepository()->findAllByIsUserDefined($isUserDefined);
    }

    /**
     * Intializes the existing attributes for the entity with the passed entity ID.
     *
     * @param integer $entityId The entity ID of the entity to load the attributes for
     *
     * @return array The entity attributes
     */
    public function getCustomerAttributesByEntityId($entityId)
    {
        return $this->getCustomerAttributeAssembler()->getCustomerAttributesByEntityId($entityId);
    }

    /**
     * Load's and return's the EAV attribute option value with the passed code, store ID and value.
     *
     * @param string  $attributeCode The code of the EAV attribute option to load
     * @param integer $storeId       The store ID of the attribute option to load
     * @param string  $value         The value of the attribute option to load
     *
     * @return array The EAV attribute option value
     * @deprecated Since 4.0.0
     * @see \TechDivision\Import\Services\EavAwareProcessorInterface::loadAttributeOptionValueByEntityTypeIdAndAttributeCodeAndStoreIdAndValue()
     */
    public function loadEavAttributeOptionValueByAttributeCodeAndStoreIdAndValue($attributeCode, $storeId, $value)
    {
        return $this->getEavAttributeOptionValueRepository()->findOneByAttributeCodeAndStoreIdAndValue($attributeCode, $storeId, $value);
    }

    /**
     * Load's and return's the EAV attribute option value with the passed entity type ID, code, store ID and value.
     *
     * @param string  $entityTypeId  The entity type ID of the EAV attribute to load the option value for
     * @param string  $attributeCode The code of the EAV attribute option to load
     * @param integer $storeId       The store ID of the attribute option to load
     * @param string  $value         The value of the attribute option to load
     *
     * @return array The EAV attribute option value
     */
    public function loadAttributeOptionValueByEntityTypeIdAndAttributeCodeAndStoreIdAndValue($entityTypeId, $attributeCode, $storeId, $value)
    {
        return $this->getEavAttributeOptionValueRepository()->findOneByEntityTypeIdAndAttributeCodeAndStoreIdAndValue($entityTypeId, $attributeCode, $storeId, $value);
    }

    /**
     * Return's an EAV entity type with the passed entity type code.
     *
     * @param string $entityTypeCode The code of the entity type to return
     *
     * @return array The entity type with the passed entity type code
     */
    public function loadEavEntityTypeByEntityTypeCode($entityTypeCode)
    {
        return $this->getEavEntityTypeRepository()->findOneByEntityTypeCode($entityTypeCode);
    }

    /**
     * Return's the customer with the passed email and website ID.
     *
     * @param string $email     The email of the customer to return
     * @param string $websiteId The website ID of the customer to return
     *
     * @return array|null The customer
     */
    public function loadCustomerByEmailAndWebsiteId($email, $websiteId)
    {
        return $this->getCustomerRepository()->findOneByEmailAndWebsiteId($email, $websiteId);
    }

    /**
     * Persist's the passed customer data and return's the ID.
     *
     * @param array       $customer The customer data to persist
     * @param string|null $name     The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function persistCustomer($customer, $name = null)
    {
        return $this->getCustomerAction()->persist($customer, $name);
    }

    /**
     * Persist's the passed customer varchar attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerVarcharAttribute($attribute, $name = null)
    {
        $this->getCustomerVarcharAction()->persist($attribute, $name);
    }

    /**
     * Persist's the passed customer integer attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerIntAttribute($attribute, $name = null)
    {
        $this->getCustomerIntAction()->persist($attribute, $name);
    }

    /**
     * Persist's the passed customer decimal attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerDecimalAttribute($attribute, $name = null)
    {
        $this->getCustomerDecimalAction()->persist($attribute, $name);
    }

    /**
     * Persist's the passed customer datetime attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerDatetimeAttribute($attribute, $name = null)
    {
        $this->getCustomerDatetimeAction()->persist($attribute, $name);
    }

    /**
     * Persist's the passed customer text attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerTextAttribute($attribute, $name = null)
    {
        $this->getCustomerTextAction()->persist($attribute, $name);
    }

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomer($row, $name = null)
    {
        $this->getCustomerAction()->delete($row, $name);
    }

    /**
     * Delete's the customer datetime attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerDatetimeAttribute($row, $name = null)
    {
        $this->getCustomerDatetimeAction()->delete($row, $name);
    }

    /**
     * Delete's the customer decimal attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerDecimalAttribute($row, $name = null)
    {
        $this->getCustomerDecimalAction()->delete($row, $name);
    }

    /**
     * Delete's the customer integer attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerIntAttribute($row, $name = null)
    {
        $this->getCustomerIntAction()->delete($row, $name);
    }

    /**
     * Delete's the customer text attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerTextAttribute($row, $name = null)
    {
        $this->getCustomerTextAction()->delete($row, $name);
    }

    /**
     * Delete's the customer varchar attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerVarcharAttribute($row, $name = null)
    {
        $this->getCustomerVarcharAction()->delete($row, $name);
    }

    /**
     * Clean-Up the repositories to free memory.
     *
     * @return void
     */
    public function cleanUp()
    {
        // flush the cache
    }
}
