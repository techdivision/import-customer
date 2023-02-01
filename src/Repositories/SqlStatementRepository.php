<?php

/**
 * TechDivision\Import\Customer\Utils\SqlStatements
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

use TechDivision\Import\Customer\Utils\SqlStatementKeys;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class SqlStatementRepository extends \TechDivision\Import\Repositories\SqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::CUSTOMER =>
            'SELECT *
               FROM ${table:customer_entity}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_BY_EMAIL_AND_WEBSITE_ID =>
            'SELECT *
               FROM ${table:customer_entity}
              WHERE email = :email
                AND website_id = :website_id',
        SqlStatementKeys::CUSTOMER_BY_WEBSITE_ID_AND_INCREMET_ID =>
            'SELECT *
               FROM ${table:customer_entity}
              WHERE website_id = :website_id
                AND increment_id = :increment_id',
        SqlStatementKeys::CUSTOMERS =>
            'SELECT *
               FROM ${table:customer_entity}',
        SqlStatementKeys::CUSTOMER_DATETIMES =>
            'SELECT *
               FROM ${table:customer_entity_datetime}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_DECIMALS =>
            'SELECT *
               FROM ${table:customer_entity_decimal}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_INTS =>
            'SELECT *
               FROM ${table:customer_entity_int}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_TEXTS =>
            'SELECT *
               FROM ${table:customer_entity_text}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_VARCHARS =>
            'SELECT *
               FROM ${table:customer_entity_varchar}
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_VARCHAR_BY_ATTRIBUTE_CODE_AND_ENTITY_TYPE_ID_AND_VALUE =>
            'SELECT t1.*
               FROM ${table:customer_entity_varchar} t1,
                    ${table:eav_attribute} t2
              WHERE t2.attribute_code = :attribute_code
                AND t2.entity_type_id = :entity_type_id
                AND t1.attribute_id = t2.attribute_id
                AND t1.value = :value',
        SqlStatementKeys::CREATE_CUSTOMER =>
            'INSERT
               INTO ${table:customer_entity}
                    (${column-names:customer_entity})
             VALUES (${column-placeholders:customer_entity})',
        SqlStatementKeys::UPDATE_CUSTOMER =>
             'UPDATE ${table:customer_entity}
                 SET ${column-values:customer_entity}
               WHERE entity_id = :entity_id',
        SqlStatementKeys::DELETE_CUSTOMER =>
             'DELETE
                FROM ${table:customer_entity}
               WHERE website_id = :website_id
                 AND email = :email',
        SqlStatementKeys::CREATE_CUSTOMER_DATETIME =>
            'INSERT
               INTO ${table:customer_entity_datetime}
                    (entity_id,
                     attribute_id,
                     value)
            VALUES (:entity_id,
                    :attribute_id,
                    :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_DATETIME =>
            'UPDATE ${table:customer_entity_datetime}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_DATETIME =>
            'DELETE
               FROM ${table:customer_entity_datetime}
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_DECIMAL =>
            'INSERT
               INTO ${table:customer_entity_decimal}
                    (entity_id,
                     attribute_id,
                     value)
            VALUES (:entity_id,
                    :attribute_id,
                    :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_DECIMAL =>
            'UPDATE ${table:customer_entity_decimal}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_DECIMAL =>
            'DELETE
               FROM ${table:customer_entity_decimal}
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_INT =>
            'INSERT
               INTO ${table:customer_entity_int}
                    (entity_id,
                     attribute_id,
                     value)
             VALUES (:entity_id,
                     :attribute_id,
                     :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_INT =>
            'UPDATE ${table:customer_entity_int}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_INT =>
            'DELETE
               FROM ${table:customer_entity_int}
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_VARCHAR =>
            'INSERT
               INTO ${table:customer_entity_varchar}
                    (entity_id,
                     attribute_id,
                     value)
             VALUES (:entity_id,
                     :attribute_id,
                     :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_VARCHAR =>
            'UPDATE ${table:customer_entity_varchar}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_VARCHAR =>
            'DELETE
               FROM ${table:customer_entity_varchar}
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_TEXT =>
            'INSERT
               INTO ${table:customer_entity_text}
                    (entity_id,
                     attribute_id,
                     value)
             VALUES (:entity_id,
                     :attribute_id,
                     :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_TEXT =>
            'UPDATE ${table:customer_entity_text}
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_TEXT =>
            'DELETE
               FROM ${table:customer_entity_text}
              WHERE value_id = :value_id',
    );

    /**
     * Initializes the SQL statement repository with the primary key and table prefix utility.
     *
     * @param \IteratorAggregate<\TechDivision\Import\Dbal\Utils\SqlCompilerInterface> $compilers The array with the compiler instances
     */
    public function __construct(\IteratorAggregate $compilers)
    {

        // pass primary key + table prefix utility to parent instance
        parent::__construct($compilers);

        // compile the SQL statements
        $this->compile($this->statements);
    }
}
