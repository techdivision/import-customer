<?php

/**
 * TechDivision\Import\Customer\Plugins\GlobalDataPlugin
 *
 * PHP version 7
 *
 * @author    MET  <met@techdivision.com>
 * @copyright 2023 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
declare(strict_types=1);

namespace TechDivision\Import\Customer\Plugins;

use TechDivision\Import\ApplicationInterface;
use TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface;
use TechDivision\Import\Plugins\AbstractPlugin;
use TechDivision\Import\Customer\Address\Utils\RegistryKeys;

/**
 * Plugin that loads the global data.
 *
 * @author    MET  <met@techdivision.com>
 * @copyright 2023 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import
 * @link      http://www.techdivision.com
 */
class GlobalDataPlugin extends AbstractPlugin
{
    /**
     * @var CustomerBunchProcessorInterface
     */
    protected $customerBunchProcessor;

    /**
     * @param ApplicationInterface $application
     * @param CustomerBunchProcessorInterface $customerBunchProcessor
     */
    public function __construct(
        ApplicationInterface $application,
        CustomerBunchProcessorInterface $customerBunchProcessor
    ){
        $this->customerBunchProcessor = $customerBunchProcessor;
        parent::__construct($application);
    }

    /**
     * Process the plugin functionality.
     *
     * @return void
     * @throws \Exception Is thrown, if the plugin can not be processed
     */
    public function process()
    {
        // initialize the array for the global data
        $globalData = array();

        // initialize the global data
        $globalData[RegistryKeys::COUNTRY_REGIONS] = $this->getCountryRegions();

        $globalData = array_merge($this->getImportProcessor()->getGlobalData(), $globalData);

        // add the status with the global data
        $this->getRegistryProcessor()->mergeAttributesRecursive(
            RegistryKeys::STATUS,
            array(RegistryKeys::GLOBAL_DATA => $globalData)
        );
    }

    /**
     * @return mixed
     */
    public function getCountryRegions()
    {
        return $this->customerBunchProcessor->loadDirectoryCountryRegions();
    }
}
