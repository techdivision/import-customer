<?php

/**
 * TechDivision\Import\Customer\Repositories\CustomerRepositoryInterface
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Repositories;

use TechDivision\Import\Dbal\Repositories\RepositoryInterface;

/**
 * Interface for a repository implementation to load customer data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
interface CustomerRepositoryInterface extends RepositoryInterface
{

    /**
     * Return's the available customers.
     *
     * @return array The available customers
     */
    public function findAll();

    /**
     * Return's the customer with the passed entity ID.
     *
     * @param integer $id The entity ID of the customer to return
     *
     * @return array|null The customer
     */
    public function load($id);

    /**
     * Return's the customer with the passed email and website ID.
     *
     * @param string $email     The email of the customer to return
     * @param string $websiteId The website ID of the customer to return
     *
     * @return array|null The customer
     */
    public function findOneByEmailAndWebsiteId($email, $websiteId);

    /**
     * Return's the customer with the passed email, website ID and increment id.
     *
     * @param string $websiteId The website ID of the customer to return
     * @param string $increment_id The website ID of the customer to return
     *
     * @return array|null The customer
     */
    public function loadCustomerByWebsiteIdAndIncrementId($websiteId, $increment_id);

    /**
     * Return's all country regions from directory
     *
     * @return array
     */
    public function findDirectoryCountryRegions();
}
