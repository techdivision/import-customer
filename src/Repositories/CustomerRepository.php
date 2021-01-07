<?php

/**
 * TechDivision\Import\Customer\Repositories\CustomerRepository
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

namespace TechDivision\Import\Customer\Repositories;

use TechDivision\Import\Customer\Utils\MemberNames;
use TechDivision\Import\Customer\Utils\SqlStatementKeys;
use TechDivision\Import\Dbal\Repositories\AbstractRepository;

/**
 * Repository implementation to load customer data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class CustomerRepository extends AbstractRepository implements CustomerRepositoryInterface
{

    /**
     * The prepared statement to load a customer with the passed entity ID.
     *
     * @var \PDOStatement
     */
    protected $customerStmt;

    /**
     * The prepared statement to load a customer with the passed email and website ID.
     *
     * @var \PDOStatement
     */
    protected $customerByEmailAndWebsiteIdStmt;

    /**
     * The prepared statement to load the existing customers.
     *
     * @var \PDOStatement
     */
    protected $customersStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->customerStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER));
        $this->customerByEmailAndWebsiteIdStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER_BY_EMAIL_AND_WEBSITE_ID));
        $this->customersStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMERS));
    }

    /**
     * Return's the available customers.
     *
     * @return array The available customers
     */
    public function findAll()
    {
        // load and return the available customers
        $this->customersStmt->execute();
        return $this->customersStmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Return's the customer with the passed entity ID.
     *
     * @param integer $id The entity ID of the customer to return
     *
     * @return array|null The customer
     */
    public function load($id)
    {

        // if not, try to load the customer with the passed entity ID
        $this->customerStmt->execute(array(MemberNames::ENTITY_ID => $id));
        return $this->customerStmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Return's the customer with the passed email and website ID.
     *
     * @param string $email     The email of the customer to return
     * @param string $websiteId The website ID of the customer to return
     *
     * @return array|null The customer
     */
    public function findOneByEmailAndWebsiteId($email, $websiteId)
    {

        // initialize the params
        $params = array(
            MemberNames::EMAIL      => $email,
            MemberNames::WEBSITE_ID => $websiteId
        );

        // if not, try to load the customer with the passed email and website ID
        $this->customerByEmailAndWebsiteIdStmt->execute($params);
        return $this->customerByEmailAndWebsiteIdStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
