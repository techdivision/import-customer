<?php

/**
 * TechDivision\Import\Customer\Repositories\CustomerDecimalRepository
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

use TechDivision\Import\Customer\Utils\ParamNames;
use TechDivision\Import\Customer\Utils\SqlStatementKeys;
use TechDivision\Import\Dbal\Repositories\AbstractRepository;

/**
 * Repository implementation to load customer decimal attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class CustomerDecimalRepository extends AbstractRepository implements CustomerDecimalRepositoryInterface
{

    /**
     * The prepared statement to load the existing customer decimal attributes with the passed entity/store ID.
     *
     * @var \PDOStatement
     */
    protected $customerDecimalsStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->customerDecimalsStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER_DECIMALS));
    }

    /**
     * Load's and return's the decimal attributes for the passed entity ID.
     *
     * @param integer $entityId The entity ID of the attributes
     *
     * @return array The decimal attributes
     */
    public function findAllByEntityId($entityId)
    {

        // prepare the params
        $params = array(ParamNames::ENTITY_ID => $entityId);

        // load and return the customer decimal attributes with the passed entity ID
        $this->customerDecimalsStmt->execute($params);
        return $this->customerDecimalsStmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
