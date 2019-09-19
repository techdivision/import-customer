<?php

/**
 * TechDivision\Import\Product\Services\ProductBunchProcessorInterface
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

use TechDivision\Import\Services\EavAwareProcessorInterface;

/**
 * Interface for a customer bunch processor.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
interface CustomerBunchProcessorInterface extends CustomerProcessorInterface, EavAwareProcessorInterface
{

    /**
     * Return's the repository to load the customers with.
     *
     * @return \TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface The repository instance
     */
    public function getCustomerRepository();

    /**
     * Return's the action with the customer CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerAction();

    /**
     * Return's the action with the customer varchar attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerVarcharAction();

    /**
     * Return's the action with the customer text attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerTextAction();

    /**
     * Return's the action with the customer int attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerIntAction();

    /**
     * Return's the action with the customer decimal attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerDecimalAction();

    /**
     * Return's the action with the customer datetime attribute CRUD methods.
     *
     * @return \TechDivision\Import\Actions\ActionInterface The action instance
     */
    public function getCustomerDatetimeAction();

    /**
     * Return's the assembler to load the customer attributes with.
     *
     * @return \TechDivision\Import\Customer\Assemblers\CustomerAttributeAssemblerInterface The assembler instance
     */
    public function getCustomerAttributeAssembler();

    /**
     * Return's the repository to access EAV attribute option values.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeOptionValueRepositoryInterface The repository instance
     */
    public function getEavAttributeOptionValueRepository();

    /**
     * Return's the repository to access EAV attributes.
     *
     * @return \TechDivision\Import\Repositories\EavAttributeRepositoryInterface The repository instance
     */
    public function getEavAttributeRepository();

    /**
     * Return's the repository to access EAV entity types.
     *
     * @return \TechDivision\Import\Repositories\EavEntityTypeRepositoryInterface The repository instance
     */
    public function getEavEntityTypeRepository();

    /**
     * Return's an array with the available EAV attributes for the passed is user defined flag.
     *
     * @param integer $isUserDefined The flag itself
     *
     * @return array The array with the EAV attributes matching the passed flag
     */
    public function getEavAttributeByIsUserDefined($isUserDefined = 1);

    /**
     * Intializes the existing attributes for the entity with the passed entity ID.
     *
     * @param integer $entityId The entity ID of the entity to load the attributes for
     *
     * @return array The entity attributes
     */
    public function getCustomerAttributesByEntityId($entityId);

    /**
     * Return's the customer with the passed email and website ID.
     *
     * @param string $email     The email of the customer to return
     * @param string $websiteId The website ID of the customer to return
     *
     * @return array|null The customer
     */
    public function loadCustomerByEmailAndWebsiteId($email, $websiteId);

    /**
     * Persist's the passed customer data and return's the ID.
     *
     * @param array       $customer The customer data to persist
     * @param string|null $name     The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function persistCustomer($customer, $name = null);

    /**
     * Persist's the passed customer varchar attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerVarcharAttribute($attribute, $name = null);

    /**
     * Persist's the passed customer integer attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerIntAttribute($attribute, $name = null);

    /**
     * Persist's the passed customer decimal attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerDecimalAttribute($attribute, $name = null);

    /**
     * Persist's the passed customer datetime attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerDatetimeAttribute($attribute, $name = null);

    /**
     * Persist's the passed customer text attribute.
     *
     * @param array       $attribute The attribute to persist
     * @param string|null $name      The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistCustomerTextAttribute($attribute, $name = null);

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomer($row, $name = null);

    /**
     * Delete's the customer datetime attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerDatetimeAttribute($row, $name = null);

    /**
     * Delete's the customer decimal attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerDecimalAttribute($row, $name = null);

    /**
     * Delete's the customer integer attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerIntAttribute($row, $name = null);

    /**
     * Delete's the customer text attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerTextAttribute($row, $name = null);

    /**
     * Delete's the customer varchar attribute with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteCustomerVarcharAttribute($row, $name = null);

    /**
     * Clean-Up the repositories to free memory.
     *
     * @return void
     */
    public function cleanUp();
}
