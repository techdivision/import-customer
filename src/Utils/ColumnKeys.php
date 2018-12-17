<?php

/**
 * TechDivision\Import\Customer\Utils\ColumnKeys
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
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class ColumnKeys extends \TechDivision\Import\Utils\ColumnKeys
{

    /**
     * Name for the column 'website_id'.
     *
     * @var string
     */
    const WEBSITE_ID = 'website_id';

    /**
     * Name for the column 'store_id'.
     *
     * @var string
     */
    const STORE_ID = 'store_id';

    /**
     * Name for the column 'group_id'.
     *
     * @var string
     */
    const GROUP_ID = 'group_id';

    /**
     * Name for the column 'created_in'.
     *
     * @var string
     */
    const CREATED_IN = 'created_in';

    /**
     * Name for the column 'created_at'.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * Name for the column 'updated_at'.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * Name for the column 'email'.
     *
     * @var string
     */
    const EMAIL = 'email';

    /**
     * Name for the column 'confirmation'.
     *
     * @var string
     */
    const CONFIRMATION = 'confirmation';

    /**
     * Name for the column 'prefix'.
     *
     * @var string
     */
    const PREFIX = 'prefix';

    /**
     * Name for the column 'suffix'.
     *
     * @var string
     */
    const SUFFIX = 'suffix';

    /**
     * Name for the column 'disable_auto_group_change'.
     *
     * @var string
     */
    const DISABLE_AUTO_GROUP_CHANGE = 'disable_auto_group_change';

    /**
     * Name for the column 'dob'.
     *
     * @var string
     */
    const DOB = 'dob';

    /**
     * Name for the column 'firstname'.
     *
     * @var string
     */
    const FIRSTNAME = 'firstname';

    /**
     * Name for the column 'lastname'.
     *
     * @var string
     */
    const LASTNAME = 'lastname';

    /**
     * Name for the column 'gender'.
     *
     * @var string
     */
    const GENDER = 'gender';

    /**
     * Name for the column 'middlename'.
     *
     * @var string
     */
    const MIDDLENAME = 'middlename';

    /**
     * Name for the column 'password_hash'.
     *
     * @var string
     */
    const PASSWORD_HASH = 'password_hash';

    /**
     * Name for the column 'password'.
     *
     * @var string
     */
    const PASSWORD = 'password';

    /**
     * Name for the column 'rp_token'.
     *
     * @var string
     */
    const RP_TOKEN = 'rp_token';

    /**
     * Name for the column 'rp_token_created_at'.
     *
     * @var string
     */
    const RP_TOKEN_CREATED_AT = 'rp_token_created_at';

    /**
     * Name for the column 'taxvat'.
     *
     * @var string
     */
    const TAXVAT = 'taxvat';

    /**
     * Name for the column '_website'.
     *
     * @var string
     */
    const WEBSITE = '_website';

    /**
     * Name for the column '_store'.
     *
     * @var string
     */
    const STORE = '_store';

    /**
     * Name for the column 'default_billing'.
     *
     * @var string
     */
    const DEFAULT_BILLING = 'default_billing';

    /**
     * Name for the column 'default_shipping'.
     *
     * @var string
     */
    const DEFAULT_SHIPPING = 'default_shipping';
}
