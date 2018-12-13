<?php

/**
 * TechDivision\Import\Customer\Repositories\CustomerVarcharRepository
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
use TechDivision\Import\Repositories\AbstractRepository;

/**
 * Repository implementation to load customer varchar attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class CustomerVarcharRepository extends AbstractRepository implements CustomerVarcharRepositoryInterface
{

    /**
     * The prepared statement to load the existing customer varchar attributes with the passed entity/store ID.
     *
     * @var \PDOStatement
     */
    protected $customerVarcharsStmt;

    /**
     * The prepared statement to load the existing customer varchar attribute with the passed attribute code
     * entity type/store ID as well as the passed value.
     *
     * @var \PDOStatement
     */
    protected $customerVarcharByAttributeCodeAndEntityTypeIdAndAndValueStmt;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // initialize the prepared statements
        $this->customerVarcharsStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER_VARCHARS));
        $this->customerVarcharByAttributeCodeAndEntityTypeIdAndAndValueStmt =
            $this->getConnection()->prepare($this->loadStatement(SqlStatementKeys::CUSTOMER_VARCHAR_BY_ATTRIBUTE_CODE_AND_ENTITY_TYPE_ID_AND_VALUE));
    }

    /**
     * Load's and return's the varchar attributes for the passed entity ID.
     *
     * @param integer $entityId The entity ID of the attributes
     *
     * @return array The varchar attributes
     */
    public function findAllByEntityId($entityId)
    {

        // prepare the params
        $params = array(ParamNames::ENTITY_ID => $entityId);

        // load and return the customer varchar attributes with the passed entity ID
        $this->customerVarcharsStmt->execute($params);
        return $this->customerVarcharsStmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Load's and return's the varchar attribute with the passed params.
     *
     * @param integer $attributeCode The attribute code of the varchar attribute
     * @param integer $entityTypeId  The entity type ID of the varchar attribute
     * @param string  $value         The value of the varchar attribute
     *
     * @return array|null The varchar attribute
     */
    public function findOneByAttributeCodeAndEntityTypeIdAndAndValue($attributeCode, $entityTypeId, $value)
    {

        // prepare the params
        $params = array(
            ParamNames::ATTRIBUTE_CODE => $attributeCode,
            ParamNames::ENTITY_TYPE_ID => $entityTypeId,
            ParamNames::VALUE          => $value
        );

        // load and return the customer varchar attribute with the passed parameters
        $this->customerVarcharByAttributeCodeAndEntityTypeIdAndAndValueStmt->execute($params);
        return $this->customerVarcharByAttributeCodeAndEntityTypeIdAndAndValueStmt->fetch(\PDO::FETCH_ASSOC);
    }
}
