<?php


namespace Mpp\GeneraliClientBundle\Model;


class ScheduledFreePayment
{
    /**
     * @var string
     */
    protected $bankDebitDay;

    /**
     * @var string
     */
    protected $amount;

    /**
     * @var string
     */
    protected $periodicity;

    /**
     * @var array
     */
    protected $repartition;

    /**
     * ScheduledFreePayment constructor.
     */
    public function __construct()
    {
        $this->repartition = [];
    }

    /**
     * @param OptionsResolver $resolver
     */
    public static function configureDate(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('bankDebitDay', null)->setAllowedTypes('bankDebitDay', ['string', 'null'])
            ->setDefault('amount', null)->setAllowedTypes('amount', ['float', 'null'])
            ->setDefault('periodicity', null)->setAllowedTypes('periodicity', ['string', 'null'])
            ->setDefault('repartition', null)->setAllowedTypes('repartition', ['array'])->setNormalizer('repartition', function(Options $options, $values): array {
                $result = [];
                foreach ($values as $value){
                    $result[] = Repartition::createFromArray($value);
                }
            });
    }

    /**
     * @param array $data
     * @return ScheduledFreePayment
     */
    public static function createFromArray(array $data)
    {
        $resolver = new OptionsResolver();
        self::configureData($resolver);
        $resolvedData = $resolver->resolve($data);

        return (new self())
            ->setBankDebitDay($resolvedData['bankDebitDay'])
            ->setAmount($resolvedData['amount'])
            ->setPeriodicity($resolvedData['periodicity'])
            ->setRepartition($resolvedData['repartition'])
            ;
    }

    /**
     * @param array $repartition
     * @return ScheduledFreePayment
     */
    public function setRepartition(array $repartition): self
    {
        $this->repartition = $repartition;
    }

    /**
     * @return array
     */
    public function getRepartition(): array
    {
        return $this->repartition;
    }

    /**
     * @param string $periodicity
     * @return ScheduledFreePayment
     */
    public function setPeriodicity(string $periodicity): self
    {
        $this->periodicity = $periodicity;
    }

    /**
     * @return string
     */
    public function getPeriodicity(): string
    {
        return $this->periodicity;
    }

    /**
     * @param string $amount
     * @return ScheduledFreePayment
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @param string $bankDebitDay
     * @return ScheduledFreePayment
     */
    public function setBankDebitDay(string $bankDebitDay): self
    {
        $this->bankDebitDay = $bankDebitDay;

        return $this;
    }

    /**
     * @return string
     */
    public function getBankDebitDay(): string
    {
        return $this->bankDebitDay;
    }

}