<?php

/**
 * TechDivision\Import\Customer\Callbacks\MultiselectCallback
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Callbacks;

use TechDivision\Import\Customer\Utils\ColumnKeys;
use TechDivision\Import\Callbacks\AbstractMultiselectCallback;

/**
 * A callback implementation that converts the passed multiselect value.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class MultiselectCallback extends AbstractMultiselectCallback
{

    /**
     * Return's the customer email as unique identifier of the actual row.
     *
     * @return mixed The row's unique identifier
     */
    protected function getUniqueIdentifier()
    {
        return $this->getValue(ColumnKeys::EMAIL).'-'.$this->getValue(ColumnKeys::WEBSITE);
    }
}
