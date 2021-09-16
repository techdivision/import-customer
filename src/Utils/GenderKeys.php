<?php

/**
 * TechDivision\Import\Customer\Utils\GenderKeys
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Utils;

/**
 * Utility class containing the available gender keys.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class GenderKeys
{

    /**
     * Key for 'Male'.
     *
     * @var integer
     */
    const GENDER_MALE = 1;

    /**
     * Key for 'Female'.
     *
     * @var integer
     */
    const GENDER_FEMALE = 2;

    /**
     * Key for 'Not Specified'.
     *
     * @var integer
     */
    const GENDER_NOT_SPECIFIED = 3;

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     */
    private function __construct()
    {
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }
}
