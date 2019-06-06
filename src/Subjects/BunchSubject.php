<?php

/**
 * TechDivision\Import\Customer\Subjects\BunchSubject
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

namespace TechDivision\Import\Customer\Subjects;

use TechDivision\Import\Subjects\ExportableTrait;
use TechDivision\Import\Subjects\ExportableSubjectInterface;
use TechDivision\Import\Customer\Utils\RegistryKeys;

/**
 * The subject implementation that handles the business logic to persist customers.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class BunchSubject extends AbstractCustomerSubject implements ExportableSubjectInterface
{

    /**
     * The trait that implements the export functionality.
     *
     * @var \TechDivision\Import\Subjects\ExportableTrait
     */
    use ExportableTrait;

    /**
     * The array with the pre-loaded entity IDs.
     *
     * @var array
     */
    protected $preLoadedEntityIds = array();

    /**
     * Clean up the global data after importing the bunch.
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function tearDown($serial)
    {

        // invoke the parent method
        parent::tearDown($serial);

        // load the registry processor
        $registryProcessor = $this->getRegistryProcessor();

        // update the status
        $registryProcessor->mergeAttributesRecursive(
            RegistryKeys::STATUS,
            array(
                RegistryKeys::PRE_LOADED_ENTITY_IDS => $this->preLoadedEntityIds,
            )
        );
    }
}
