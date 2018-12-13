<?php

/**
 * TechDivision\Import\Customer\Observers\ClearCustomerObserver
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

namespace TechDivision\Import\Customer\Observers;

use TechDivision\Import\Customer\Utils\ColumnKeys;
use TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface;
use TechDivision\Import\Customer\Utils\MemberNames;

/**
 * Observer that removes the customer with the identifier found in the CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class ClearCustomerObserver extends AbstractCustomerImportObserver
{

    /**
     * The customer bunch processor instance.
     *
     * @var \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface
     */
    protected $customerBunchProcessor;

    /**
     * Initialize the observer with the passed customer bunch processor instance.
     *
     * @param \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface $customerBunchProcessor The customer bunch processor instance
     */
    public function __construct(CustomerBunchProcessorInterface $customerBunchProcessor)
    {
        $this->customerBunchProcessor = $customerBunchProcessor;
    }

    /**
     * Return's the customer bunch processor instance.
     *
     * @return \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface The customer bunch processor instance
     */
    protected function getCustomerBunchProcessor()
    {
        return $this->customerBunchProcessor;
    }

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {

        // load email and website code
        $email = $this->getValue(ColumnKeys::EMAIL);
        $website = $this->getValue(ColumnKeys::WEBSITE);

        // query whether or not, we've found a new SKU => means we've found a new customer
        if ($this->isLastIdentifier($identifier = array(MemberNames::EMAIL => $email, MemberNames::WEBSITE => $website))) {
            return;
        }

        // delete the customer with the passed SKU
        $this->deleteCustomer($identifier);

        // flush the cache to remove the deleted customer (which has previously been cached)
        $this->getCustomerBunchProcessor()->cleanUp();
    }

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    protected function deleteCustomer($row, $name = null)
    {
        $this->getCustomerBunchProcessor()->deleteCustomer($row, $name);
    }
}
