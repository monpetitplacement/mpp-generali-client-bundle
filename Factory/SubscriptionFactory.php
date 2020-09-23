<?php

namespace Mpp\GeneraliClientBundle\Factory;

use Mpp\GeneraliClientBundle\Handler\ReferentialHandler;
use Mpp\GeneraliClientBundle\HttpClient\GeneraliHttpClientInterface;
use Mpp\GeneraliClientBundle\Model\Context;
use Mpp\GeneraliClientBundle\Model\Subscriber;
use Mpp\GeneraliClientBundle\Model\Subscription;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SubscriptionFactory
 */
class SubscriptionFactory extends AbstractFactory
{
    /**
     * @var SubscriberFactory
     */
    private $subscriberFactory;

    /**
     * @var CustomerFolderFactory
     */
    private $customerFolderFactory;

    /**
     * @var SettlementFactory
     */
    private $settlementFactory;

    /**
     * @var InitialPaymentFactory
     */
    private $initialPaymentFactory;

    /**
     * @var ScheduledFreePaymentFactory
     */
    private $scheduledFreePayment;

    /**
     * SubscriptionFactory constructor.
     * @param GeneraliHttpClientInterface $httpClient
     * @param SubscriberFactory $subscriberFactory
     * @param CustomerFolderFactory $customerFolderFactory
     * @param SettlementFactory $settlementFactory
     * @param InitialPaymentFactory $initialPaymentFactory
     */
    public function __construct(
        GeneraliHttpClientInterface $httpClient,
        SubscriberFactory $subscriberFactory,
        CustomerFolderFactory $customerFolderFactory,
        SettlementFactory $settlementFactory,
        InitialPaymentFactory $initialPaymentFactory,
        ScheduledFreePaymentFactory $scheduledFreePaymentFactory
    ) {
        parent::__construct($httpClient);
        $this->subscriberFactory = $subscriberFactory;
        $this->customerFolderFactory = $customerFolderFactory;
        $this->settlementFactory = $settlementFactory;
        $this->scheduledFreePaymentFactory = $scheduledFreePaymentFactory;
        $this->initialPaymentFactory = $initialPaymentFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function configureData(OptionsResolver $resolver): void
    {
        $beneficiaryClauseCodes = $this->getExpectedItemCodes(Context::EXPECTED_ITEM_BENEFICIARY_CLAUSE);

        $resolver
            ->setRequired('externalReference1')->setAllowedTypes('externalReference1', ['string'])
            ->setDefined('externalReference2')->setAllowedTypes('externalReference2', ['string'])
            ->setRequired('subscriber')->setAllowedTypes('subscriber', ['array', 'null'])->setNormalizer('subscriber', function (Options $options, $value) {
                return $this->subscriberFactory->create($value);
            })
            ->setRequired('customerFolder')->setAllowedTypes('customerFolder', ['array'])->setNormalizer('customerFolder', function (Options $options, $value) {
                return $this->customerFolderFactory->create($value);
            })
            ->setRequired('settlement')->setAllowedTypes('settlement', ['array'])->setNormalizer('settlement', function (Options $options, $value) {
                return $this->settlementFactory->create($value);
            })
            ->setRequired('scheduledFreePayment')->setAllowedTypes('scheduledFreePayment', ['array'])->setNormalizer('scheduledFreePayment', function (Options $options, $value) {
                return $this->scheduledFreePaymentFactory->create($value);
            })
            ->setRequired('initialPayment')->setAllowedTypes('initialPayment', ['array'])->setNormalizer('initialPayment', function (Options $options, $value) {
                return $this->initialPaymentFactory->create($value);
            })
            ->setRequired('paymentType')->setAllowedTypes('paymentType', ['string'])
            ->setRequired('fiscality')->setAllowedTypes('fiscality', ['string'])
            ->setDefined('deathBeneficiaryClauseCode')->setAllowedValues('deathBeneficiaryClauseCode', $beneficiaryClauseCodes)
            ->setDefined('deathBeneficiaryClauseText')->setAllowedTypes('deathBeneficiaryClauseText', ['string'])
            ->setRequired('gestionMode')->setAllowedTypes('gestionMode', ['string'])
            ->setRequired('durationType')->setAllowedTypes('durationType', ['string'])
            ->setDefined('duration')->setAllowedTypes('duration', ['int'])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function doCreate(array $resolvedData)
    {
        $subscription = (new Subscription())
            ->setExternalReference1($resolvedData['externalReference1'])
            ->setExternalReference2($resolvedData['externalReference2'])
            ->setSubscriber($resolvedData['subscriber'])
            ->setCustomerFolder($resolvedData['customerFolder'])
            ->setSettlement($resolvedData['settlement'])
            ->setInitialPayment($resolvedData['initialPayment'])
            ->setScheduledFreePayment($resolvedData['scheduledFreePayment'])
            ->setPaymentType($resolvedData['paymentType'])
            ->setFiscality($resolvedData['fiscality'])
            ->setDeathBeneficiaryClauseCode($resolvedData['deathBeneficiaryClauseCode'])
            ->setDeathBeneficiaryClauseText($resolvedData['deathBeneficiaryClauseText'])
            ->setGestionMode($resolvedData['gestionMode'])
            ->setDurationType($resolvedData['durationType'])
        ;
        if (isset($resolvedData['duration'])) {
            $subscription->setDuration($resolvedData['duration']);
        }

        return $subscription;
    }
}