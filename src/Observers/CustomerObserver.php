<?php

/**
 * TechDivision\Import\Customer\Observers\CustomerObserver
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Customer\Observers;

use TechDivision\Import\Observers\CleanUpEmptyColumnsTrait;
use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Utils\EntityTypeCodes;
use TechDivision\Import\Observers\StateDetectorInterface;
use TechDivision\Import\Customer\Utils\GenderKeys;
use TechDivision\Import\Customer\Utils\ColumnKeys;
use TechDivision\Import\Customer\Utils\MemberNames;
use TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface;

/**
 * Observer that create's the customer itself.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-customer
 * @link      http://www.techdivision.com
 */
class CustomerObserver extends AbstractCustomerImportObserver
{

    use CleanUpEmptyColumnsTrait;
    /**
     * The customer bunch processor instance.
     *
     * @var \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface
     */
    protected $customerBunchProcessor;

    /**
     * The array with the available gender keys.
     *
     * @var array
     */
    protected $availableGenders = array(
        'Male'          => GenderKeys::GENDER_MALE,
        'Female'        => GenderKeys::GENDER_FEMALE,
        'Not Specified' => GenderKeys::GENDER_NOT_SPECIFIED
    );

    /**
     * Initializes the observer with the state detector instance.
     *
     * @param \TechDivision\Import\Customer\Services\CustomerBunchProcessorInterface $customerBunchProcessor The customer bunch processor instance
     * @param \TechDivision\Import\Observers\StateDetectorInterface                  $stateDetector          The state detector instance
     */
    public function __construct(
        CustomerBunchProcessorInterface $customerBunchProcessor,
        StateDetectorInterface $stateDetector = null
    ) {

        // set the customer processor and the raw entity loader
        $this->customerBunchProcessor = $customerBunchProcessor;

        // pass the state detector to the parent constructor
        parent::__construct($stateDetector);
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
     * @return void
     */
    protected function process()
    {

        // load email and website code
        $email = $this->getValue(ColumnKeys::EMAIL);
        $website = $this->getValue(ColumnKeys::WEBSITE);

        // query whether or not, we've found a new SKU => means we've found a new customer
        if ($this->hasBeenProcessed(array($email, $website))) {
            return;
        }

        // prepare the static entity values
        $customer = $this->initializeCustomer($this->prepareAttributes());
        if ($this->hasChanges($customer)) {
            try {
                // insert the entity and set the entity ID
                $this->setLastEntityId($this->persistCustomer($customer));
            } catch (\Exception $e) {
                if (!$this->isStrictMode()) {
                    $message = sprintf(
                        'can\'t import customer with email %s! Error: %s',
                        $this->getValue(ColumnKeys::EMAIL),
                        $e->getMessage()
                    );
                    $this->mergeStatus(
                        array(
                            RegistryKeys::NO_STRICT_VALIDATIONS => array(
                                basename($this->getFilename()) => array(
                                    $this->getLineNumber() => array(
                                        ColumnKeys::EMAIL => $message,
                                    ),
                                ),
                            ),
                        )
                    );
                    $this->skipRow();
                } else {
                    throw $e;
                }
            }
        } else {
            // set the entity ID
            $this->setLastEntityId($customer[MemberNames::ENTITY_ID]);
        }
    }

    /**
     * Prepare the attributes of the entity that has to be persisted.
     *
     * @return array The prepared attributes
     */
    protected function prepareAttributes()
    {
        // initialize the customer values
        $email = $this->getValue(ColumnKeys::EMAIL);
        $groupId = $this->getValue(ColumnKeys::GROUP_ID);
        $storeId = $this->getValue(ColumnKeys::STORE_ID);
        $disableAutoGroupChange = $this->getValue(ColumnKeys::DISABLE_AUTO_GROUP_CHANGE);
        $prefix = $this->getValue(ColumnKeys::PREFIX);
        $firstname = $this->getValue(ColumnKeys::FIRSTNAME);
        $middlename = $this->getValue(ColumnKeys::MIDDLENAME);
        $lastname = $this->getValue(ColumnKeys::LASTNAME);
        $suffix = $this->getValue(ColumnKeys::SUFFIX);
        $passwordHash = $this->getValue(ColumnKeys::PASSWORD_HASH);
        $rpToken = $this->getValue(ColumnKeys::RP_TOKEN);
        $defaultShipping = $this->getValue(ColumnKeys::ADDRESS_DEFAULT_SHIPPING);
        $defaultBilling = $this->getValue(ColumnKeys::ADDRESS_DEFAULT_BILLING);
        $taxvat = $this->getValue(ColumnKeys::TAXVAT);
        $confirmation = $this->getValue(ColumnKeys::CONFIRMATION);
        $gender = $this->getGenderByValue($this->getValue(ColumnKeys::GENDER));

        // load the store id if a store code is present in the current row
        if (($storeCode = $this->getValue(ColumnKeys::STORE))) {
            $storeId = $this->getStoreIdByCode($storeCode);
        }

        // throw exception if neither the store id nor the store code are available
        if ($storeId === null) {
            throw new \Exception(
                sprintf(
                    'Expected value for either _store or store_id, none found in file %s on line %d',
                    $this->getFilename(),
                    $this->getLineNumber()
                )
            );
        }

        // load the customer's additional attributes
        $createdIn = $this->getValue(ColumnKeys::CREATED_IN);
        $isActive = $this->getValue(ColumnKeys::IS_ACTIVE);
        $failuresNum = 0;
        $firstFailure = null;
        $lockExpires = null;

        // prepare the date format for the created at/updated at dates
        $websiteId = $this->getStoreWebsiteIdByCode($this->getValue(ColumnKeys::WEBSITE));
        $incrementId = $this->getValue(ColumnKeys::INCREMENT_ID);
        $dob = $this->getValue(ColumnKeys::DOB, null, array($this, 'formatDobDate'));
        $createdAt = $this->getValue(ColumnKeys::CREATED_AT, date('Y-m-d H:i:s'), array($this, 'formatDate'));
        $updatedAt = $this->getValue(ColumnKeys::UPDATED_AT, date('Y-m-d H:i:s'), array($this, 'formatDate'));
        $rpTokenCreatedAt = $this->getValue(ColumnKeys::RP_TOKEN_CREATED_AT, null, array($this, 'formatDate'));
        $sessionCutoff = $this->getValue(ColumnKeys::SESSION_CUTOFF, null, array($this, 'formatDate'));

        // return the prepared customer
        return $this->initializeEntity(
            $this->loadRawEntity(
                array(
                    MemberNames::WEBSITE_ID                => $websiteId,
                    MemberNames::EMAIL                     => $email,
                    MemberNames::GROUP_ID                  => $groupId,
                    MemberNames::INCREMENT_ID              => $incrementId,
                    MemberNames::STORE_ID                  => $storeId,
                    MemberNames::CREATED_AT                => $createdAt,
                    MemberNames::UPDATED_AT                => $updatedAt,
                    MemberNames::IS_ACTIVE                 => $isActive,
                    MemberNames::DISABLE_AUTO_GROUP_CHANGE => $disableAutoGroupChange,
                    MemberNames::CREATED_IN                => $createdIn,
                    MemberNames::PREFIX                    => $prefix,
                    MemberNames::FIRSTNAME                 => $firstname,
                    MemberNames::MIDDLENAME                => $middlename,
                    MemberNames::LASTNAME                  => $lastname,
                    MemberNames::SUFFIX                    => $suffix,
                    MemberNames::DOB                       => $dob,
                    MemberNames::PASSWORD_HASH             => $passwordHash,
                    MemberNames::RP_TOKEN                  => $rpToken,
                    MemberNames::RP_TOKEN_CREATED_AT       => $rpTokenCreatedAt,
                    MemberNames::DEFAULT_BILLING           => $defaultBilling,
                    MemberNames::DEFAULT_SHIPPING          => $defaultShipping,
                    MemberNames::TAXVAT                    => $taxvat,
                    MemberNames::CONFIRMATION              => $confirmation,
                    MemberNames::GENDER                    => $gender,
                    MemberNames::FAILURES_NUM              => $failuresNum,
                    MemberNames::FIRST_FAILURE             => $firstFailure,
                    MemberNames::LOCK_EXPIRES              => $lockExpires,
                    MemberNames::SESSION_CUTOFF           => $sessionCutoff
                )
            )
        );
    }

    /**
     * Load's and return's a raw customer entity without primary key but the mandatory members only and nulled values.
     *
     * @param array $data An array with data that will be used to initialize the raw entity with
     *
     * @return array The initialized entity
     */
    protected function loadRawEntity(array $data = array())
    {
        return $this->getCustomerBunchProcessor()->loadRawEntity(EntityTypeCodes::CUSTOMER, $data);
    }

    /**
     * Initialize the customer with the passed attributes and returns an instance.
     *
     * @param array $attr The customer attributes
     *
     * @return array The initialized customer
     */
    protected function initializeCustomer(array $attr)
    {

        // load the customer with the passed SKU and merge it with the attributes
        if ($entity = $this->loadCustomerByEmailAndWebsiteId($attr[MemberNames::EMAIL], $attr[MemberNames::WEBSITE_ID])) {
            // clear row elements that are not allowed to be updated
            $attr = $this->clearRowData($attr, true);

            // remove the created at date from the attributes, when we update the entity
            unset($attr[MemberNames::CREATED_AT]);

            return $this->mergeEntity($entity, $attr);
        } else {
            // cleanup __EMPTY__VALUE__ entries, don't remove array elements
            $attr = $this->clearRowData($attr, false);
        }

        
        // New Customer always active
        if ($attr[MemberNames::IS_ACTIVE] == null) {
            $attr[MemberNames::IS_ACTIVE] = 1;
        }

        // otherwise simply return the attributes
        return $attr;
    }

    /**
     * Return's the gender ID for the passed value.
     *
     * @param string $value The value to return the gender ID for
     *
     * @return integer The gender ID
     * @throws \Exception Is thrown, if the gender ID with the requested value is not available
     */
    protected function getGenderByValue($value)
    {

        // query whether or not, the requested gender ID is available
        if (isset($this->availableGenders[$value])) {
            return (integer) $this->availableGenders[$value];
        }

        // allow null values and empty strings
        if ($value === null || $value === '') {
            return null;
        }

        // throw an exception, if not
        throw new \Exception(
            $this->appendExceptionSuffix(
                sprintf('Found invalid gender %s', $value)
            )
        );
    }

    /**
     * Returns the store id for the specified store code.
     *
     * @param string $code The store code
     *
     * @return integer The store id
     */
    protected function getStoreIdByCode($code)
    {
        return $this->getSubject()->getStoreId($code);
    }

    /**
     * Return's the store website for the passed code.
     *
     * @param string $code The code of the store website to return the ID for
     *
     * @return integer The store website ID
     */
    protected function getStoreWebsiteIdByCode($code)
    {
        return $this->getSubject()->getStoreWebsiteIdByCode($code);
    }

    /**
     * Return's the customer with the passed email and website ID.
     *
     * @param string $email     The email of the customer to return
     * @param string $websiteId The website ID of the customer to return
     *
     * @return array|null The customer
     */
    protected function loadCustomerByEmailAndWebsiteId($email, $websiteId)
    {
        return $this->getCustomerBunchProcessor()->loadCustomerByEmailAndWebsiteId($email, $websiteId);
    }

    /**
     * Persist's the passed customer data and return's the ID.
     *
     * @param array $customer The customer data to persist
     *
     * @return string The ID of the persisted entity
     */
    protected function persistCustomer($customer)
    {
        return $this->getCustomerBunchProcessor()->persistCustomer($customer);
    }

    /**
     * Return's the attribute set of the customer that has to be created.
     *
     * @return array The attribute set
     */
    protected function getAttributeSet()
    {
        return $this->getSubject()->getAttributeSet();
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
     * @param string $value DOB value
     *
     * @return null|string
     */
    protected function formatDobDate($value)
    {
        // try to format the date according to the configured date format
        $formattedDate = $this->getSubject()->getDateConverter()->convert($value);

        $format = 'Y-m-d H:i:s';
        $dateTime = \DateTime::createFromFormat($format, $formattedDate);

        if (!$dateTime) {
            return null;
        }

        // return the formatted date for birthday
        return $dateTime->format('Y-m-d');
    }
}
