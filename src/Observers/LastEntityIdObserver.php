<?php

/**
 * TechDivision\Import\Customer\Observers\LastEntityIdObserver
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
use TechDivision\Import\Customer\Utils\MemberNames;
use TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface;

/**
 * Observer that pre-loads the entity ID of the customer with the SKU found in the CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class LastEntityIdObserver extends AbstractCustomerImportObserver
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
     * @throws \Exception Is thrown, if the customer with the SKU can not be loaded
     */
    protected function process()
    {

        // query whether or not, we've found a new SKU => means we've found a new customer
        if ($this->isLastSku($sku = $this->getValue(ColumnKeys::SKU))) {
            return;
        }

        // set the entity ID for the customer with the passed SKU
        if ($customer = $this->loadCustomer($sku)) {
            $this->setIds($customer);
        } else {
            // initialize the error message
            $message = sprintf('Can\'t load entity ID for customer with SKU %s', $sku);
            // load the subject
            $subject = $this->getSubject();
            // query whether or not debug mode has been enabled
            if ($subject->isDebugMode()) {
                // log a warning, that the customer with the given SKU can not be loaded
                $subject->getSystemLogger()->warning($subject->appendExceptionSuffix($message));
                // skip processing the actual row
                $subject->skipRow();
            } else {
                throw new \Exception($message);
            }
        }
    }

    /**
     * Temporarily persist's the IDs of the passed customer.
     *
     * @param array $customer The customer to temporarily persist the IDs for
     *
     * @return void
     */
    protected function setIds(array $customer)
    {
        $this->setLastEntityId($customer[MemberNames::ENTITY_ID]);
    }

    /**
     * Set's the ID of the customer that has been created recently.
     *
     * @param string $lastEntityId The entity ID
     *
     * @return void
     */
    protected function setLastEntityId($lastEntityId)
    {
        $this->getSubject()->setLastEntityId($lastEntityId);
    }

    /**
     * Load's and return's the customer with the passed SKU.
     *
     * @param string $sku The SKU of the customer to load
     *
     * @return array The customer
     */
    protected function loadCustomer($sku)
    {
        return $this->getCustomerBunchProcessor()->loadCustomer($sku);
    }
}
