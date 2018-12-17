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

namespace TechDivision\Import\Customer\Repositories;

use TechDivision\Import\Customer\Utils\SqlStatementKeys;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
               FROM customer_entity
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_BY_EMAIL_AND_WEBSITE_ID =>
            'SELECT *
               FROM customer_entity
              WHERE email = :email
                AND website_id = :website_id',
        SqlStatementKeys::CUSTOMERS =>
            'SELECT *
               FROM customer_entity',
        SqlStatementKeys::CUSTOMER_DATETIMES =>
            'SELECT *
               FROM customer_entity_datetime
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_DECIMALS =>
            'SELECT *
               FROM customer_entity_decimal
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_INTS =>
            'SELECT *
               FROM customer_entity_int
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_TEXTS =>
            'SELECT *
               FROM customer_entity_text
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_VARCHARS =>
            'SELECT *
               FROM customer_entity_varchar
              WHERE entity_id = :entity_id',
        SqlStatementKeys::CUSTOMER_VARCHAR_BY_ATTRIBUTE_CODE_AND_ENTITY_TYPE_ID_AND_VALUE =>
            'SELECT t1.*
               FROM customer_entity_varchar t1,
                    eav_attribute t2
              WHERE t2.attribute_code = :attribute_code
                AND t2.entity_type_id = :entity_type_id
                AND t1.attribute_id = t2.attribute_id
                AND t1.value = :value',
        SqlStatementKeys::CREATE_CUSTOMER =>
            'INSERT
               INTO customer_entity
                    (website_id,
                     email,
                     group_id,
                     increment_id,
                     store_id,
                     created_at,
                     updated_at,
                     is_active,
                     disable_auto_group_change,
                     created_in,
                     prefix,
                     firstname,
                     middlename,
                     lastname,
                     suffix,
                     dob,
                     password_hash,
                     rp_token,
                     rp_token_created_at,
                     default_billing,
                     default_shipping,
                     taxvat,
                     confirmation,
                     gender,
                     failures_num,
                     first_failure,
                     lock_expires)
             VALUES (:website_id,
                     :email,
                     :group_id,
                     :increment_id,
                     :store_id,
                     :created_at,
                     :updated_at,
                     :is_active,
                     :disable_auto_group_change,
                     :created_in,
                     :prefix,
                     :firstname,
                     :middlename,
                     :lastname,
                     :suffix,
                     :dob,
                     :password_hash,
                     :rp_token,
                     :rp_token_created_at,
                     :default_billing,
                     :default_shipping,
                     :taxvat,
                     :confirmation,
                     :gender,
                     :failures_num,
                     :first_failure,
                     :lock_expires)',
        SqlStatementKeys::UPDATE_CUSTOMER =>
             'UPDATE customer_entity
                 SET website_id = :website_id,
                     email = :email,
                     group_id = :group_id,
                     increment_id = :increment_id,
                     store_id = :store_id,
                     created_at = :created_at,
                     updated_at = :updated_at,
                     is_active = :is_active,
                     disable_auto_group_change = :disable_auto_group_change,
                     created_in = :created_in,
                     prefix = :prefix,
                     firstname = :firstname,
                     middlename = :middlename,
                     lastname = :lastname,
                     suffix = :suffix,
                     dob = :dob,
                     password_hash = :password_hash,
                     rp_token = :rp_token,
                     rp_token_created_at = :rp_token_created_at,
                     default_billing = :default_billing,
                     default_shipping = :default_shipping,
                     taxvat = :taxvat,
                     confirmation = :confirmation,
                     gender = :gender,
                     failures_num = :failures_num,
                     first_failure = :first_failure,
                     lock_expires = :lock_expires
               WHERE entity_id = :entity_id',
        SqlStatementKeys::DELETE_CUSTOMER =>
             'DELETE
                FROM customer_entity
               WHERE website_id = :website_id
                 AND email = :email',
        SqlStatementKeys::CREATE_CUSTOMER_DATETIME =>
            'INSERT
               INTO customer_entity_datetime
                    (entity_id,
                     attribute_id,
                     store_id,
                     value)
            VALUES (:entity_id,
                    :attribute_id,
                    :store_id,
                    :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_DATETIME =>
            'UPDATE customer_entity_datetime
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    store_id = :store_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_DATETIME =>
            'DELETE
               FROM customer_entity_datetime
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_DECIMAL =>
            'INSERT
               INTO customer_entity_decimal
                    (entity_id,
                     attribute_id,
                     store_id,
                     value)
            VALUES (:entity_id,
                    :attribute_id,
                    :store_id,
                    :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_DECIMAL =>
            'UPDATE customer_entity_decimal
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    store_id = :store_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_DECIMAL =>
            'DELETE
               FROM customer_entity_decimal
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_INT =>
            'INSERT
               INTO customer_entity_int
                    (entity_id,
                     attribute_id,
                     store_id,
                     value)
             VALUES (:entity_id,
                     :attribute_id,
                     :store_id,
                     :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_INT =>
            'UPDATE customer_entity_int
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    store_id = :store_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_INT =>
            'DELETE
               FROM customer_entity_int
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_VARCHAR =>
            'INSERT
               INTO customer_entity_varchar
                    (entity_id,
                     attribute_id,
                     store_id,
                     value)
             VALUES (:entity_id,
                     :attribute_id,
                     :store_id,
                     :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_VARCHAR =>
            'UPDATE customer_entity_varchar
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    store_id = :store_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_VARCHAR =>
            'DELETE
               FROM customer_entity_varchar
              WHERE value_id = :value_id',
        SqlStatementKeys::CREATE_CUSTOMER_TEXT =>
            'INSERT
               INTO customer_entity_text
                    (entity_id,
                     attribute_id,
                     store_id,
                     value)
             VALUES (:entity_id,
                     :attribute_id,
                     :store_id,
                     :value)',
        SqlStatementKeys::UPDATE_CUSTOMER_TEXT =>
            'UPDATE customer_entity_text
                SET entity_id = :entity_id,
                    attribute_id = :attribute_id,
                    store_id = :store_id,
                    value = :value
              WHERE value_id = :value_id',
        SqlStatementKeys::DELETE_CUSTOMER_TEXT =>
            'DELETE
               FROM customer_entity_text
              WHERE value_id = :value_id',
    );

    /**
     * Initialize the the SQL statements.
     */
    public function __construct()
    {

        // call the parent constructor
        parent::__construct();

        // merge the class statements
        foreach ($this->statements as $key => $statement) {
            $this->preparedStatements[$key] = $statement;
        }
    }
}
