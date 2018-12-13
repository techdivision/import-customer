<?php

/**
 * TechDivision\Import\Customer\Utils\SqlStatements
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

namespace TechDivision\Import\Customer\Utils;

/**
 * Utility class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class SqlStatementKeys extends \TechDivision\Import\Utils\SqlStatementKeys
{

    /**
     * The SQL statement to load the customer with the passed entity ID.
     *
     * @var string
     */
    const CUSTOMER = 'customer';

    /**
     * The SQL statement to load the customer with the passed email and website ID.
     *
     * @var string
     */
    const CUSTOMER_BY_EMAIL_AND_WEBSITE_ID = 'customer.by.email.and.website_id';

    /**
     * The SQL statement to load the available customers.
     *
     * @var string
     */
    const CUSTOMERS = 'customers';

    /**
     * The SQL statement to load the customer datetime attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_DATETIMES = 'customer_datetimes';

    /**
     * The SQL statement to load the customer decimal attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_DECIMALS = 'customer_decimals';

    /**
     * The SQL statement to load the customer integer attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_INTS = 'customer_ints';

    /**
     * The SQL statement to load the customer text attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_TEXTS = 'customer_texts';

    /**
     * The SQL statement to load the customer varchar attributes with the passed entity/store ID.
     *
     * @var string
     */
    const CUSTOMER_VARCHARS = 'customer_varchars';

    /**
     * The SQL statement to load a customer varchar attribute by the passed attribute code,
     * entity type and the passed value.
     *
     * @var string
     */
    const CUSTOMER_VARCHAR_BY_ATTRIBUTE_CODE_AND_ENTITY_TYPE_ID_AND_VALUE = 'customer_varchar.by.attribute_code.and.entity_type_id.and.value';

    /**
     * The SQL statement to create new customers.
     *
     * @var string
     */
    const CREATE_CUSTOMER = 'create.customer';

    /**
     * The SQL statement to update an existing customer.
     *
     * @var string
     */
    const UPDATE_CUSTOMER = 'update.customer';

    /**
     * The SQL statement to delete an existing customer.
     *
     * @var string
     */
    const DELETE_CUSTOMER = 'delete.customer';

    /**
     * The SQL statement to create a new customer datetime value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_DATETIME = 'create.customer_datetime';

    /**
     * The SQL statement to update an existing customer datetime value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_DATETIME = 'update.customer_datetime';

    /**
     * The SQL statement to delete an existing customer datetime value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_DATETIME = 'delete.customer_datetime';

    /**
     * The SQL statement to create a new customer decimal value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_DECIMAL = 'create.customer_decimal';

    /**
     * The SQL statement to create a new customer relation.
     *
     * @var string
     */
    const CREATE_CUSTOMER_RELATION = 'create.customer_relation';

    /**
     * The SQL statement to update an existing customer decimal value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_DECIMAL = 'update.customer_decimal';

    /**
     * The SQL statement to delete an existing customer decimal value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_DECIMAL = 'delete.customer_decimal';

    /**
     * The SQL statement to create a new customer integer value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_INT = 'create.customer_int';

    /**
     * The SQL statement to update an existing customer integer value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_INT = 'update.customer_int';

    /**
     * The SQL statement to delete an existing customer integer value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_INT = 'delete.customer_int';

    /**
     * The SQL statement to create a new customer varchar value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_VARCHAR = 'create.customer_varchar';

    /**
     * The SQL statement to update an existing customer varchar value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_VARCHAR = 'update.customer_varchar';

    /**
     * The SQL statement to delete an existing customer varchar value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_VARCHAR = 'delete.customer_varchar';

    /**
     * The SQL statement to create a new customer text value.
     *
     * @var string
     */
    const CREATE_CUSTOMER_TEXT = 'create.customer_text';

    /**
     * The SQL statement to update an existing customer text value.
     *
     * @var string
     */
    const UPDATE_CUSTOMER_TEXT = 'update.customer_text';

    /**
     * The SQL statement to delete an existing customer text value.
     *
     * @var string
     */
    const DELETE_CUSTOMER_TEXT = 'delete.customer_text';
}
