<?php

/**
 * TechDivision\Import\Customer\Assemblers\CustomerAttributeAssembler
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Assemblers;

use TechDivision\Import\Customer\Utils\MemberNames;
use TechDivision\Import\Customer\Repositories\CustomerIntRepositoryInterface;
use TechDivision\Import\Customer\Repositories\CustomerTextRepositoryInterface;
use TechDivision\Import\Customer\Repositories\CustomerVarcharRepositoryInterface;
use TechDivision\Import\Customer\Repositories\CustomerDecimalRepositoryInterface;
use TechDivision\Import\Customer\Repositories\CustomerDatetimeRepositoryInterface;

/**
 * Assembler implementation that provides functionality to assemble customer attribute data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class CustomerAttributeAssembler implements CustomerAttributeAssemblerInterface
{

    /**
     * The customer datetime repository instance.
     *
     * @var \TechDivision\Import\Customer\Repositories\CustomerDatetimeRepositoryInterface
     */
    protected $customerDatetimeRepository;

    /**
     * The customer decimal repository instance.
     *
     * @var \TechDivision\Import\Customer\Repositories\CustomerDecimalRepositoryInterface
     */
    protected $customerDecimalRepository;

    /**
     * The customer integer repository instance.
     *
     * @var \TechDivision\Import\Customer\Repositories\CustomerIntRepositoryInterface
     */
    protected $customerIntRepository;

    /**
     * The customer text repository instance.
     *
     * @var \TechDivision\Import\Customer\Repositories\CustomerTextRepositoryInterface
     */
    protected $customerTextRepository;

    /**
     * The customer varchar repository instance.
     *
     * @var \TechDivision\Import\Customer\Repositories\CustomerVarcharRepositoryInterface
     */
    protected $customerVarcharRepository;

    /**
     * Initializes the assembler with the necessary repositories.
     *
     * @param \TechDivision\Import\Customer\Repositories\CustomerDatetimeRepositoryInterface $customerDatetimeRepository The customer datetime repository instance
     * @param \TechDivision\Import\Customer\Repositories\CustomerDecimalRepositoryInterface  $customerDecimalRepository  The customer decimal repository instance
     * @param \TechDivision\Import\Customer\Repositories\CustomerIntRepositoryInterface      $customerIntRepository      The customer integer repository instance
     * @param \TechDivision\Import\Customer\Repositories\CustomerTextRepositoryInterface     $customerTextRepository     The customer text repository instance
     * @param \TechDivision\Import\Customer\Repositories\CustomerVarcharRepositoryInterface  $customerVarcharRepository  The customer varchar repository instance
     */
    public function __construct(
        CustomerDatetimeRepositoryInterface $customerDatetimeRepository,
        CustomerDecimalRepositoryInterface $customerDecimalRepository,
        CustomerIntRepositoryInterface $customerIntRepository,
        CustomerTextRepositoryInterface $customerTextRepository,
        CustomerVarcharRepositoryInterface $customerVarcharRepository
    ) {
        $this->customerDatetimeRepository = $customerDatetimeRepository;
        $this->customerDecimalRepository = $customerDecimalRepository;
        $this->customerIntRepository = $customerIntRepository;
        $this->customerTextRepository = $customerTextRepository;
        $this->customerVarcharRepository = $customerVarcharRepository;
    }

    /**
     * Intializes the existing attributes for the entity with the passed entity ID.
     *
     * @param integer $entityId The entity ID of the entity to load the attributes for
     *
     * @return array The entity attributes
     */
    public function getCustomerAttributesByEntityId($entityId)
    {

        // initialize the array for the attributes
        $attributes = array();

        // load the datetime attributes
        foreach ($this->customerDatetimeRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // load the decimal attributes
        foreach ($this->customerDecimalRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // load the integer attributes
        foreach ($this->customerIntRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // load the text attributes
        foreach ($this->customerTextRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // load the varchar attributes
        foreach ($this->customerVarcharRepository->findAllByEntityId($entityId) as $attribute) {
            $attributes[$attribute[MemberNames::ATTRIBUTE_ID]] = $attribute;
        }

        // return the array with the attributes
        return $attributes;
    }
}
