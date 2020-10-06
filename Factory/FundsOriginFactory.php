<?php

namespace Mpp\GeneraliClientBundle\Factory;

use Laminas\Validator\Date;
use Mpp\GeneraliClientBundle\Handler\ReferentialHandler;
use Mpp\GeneraliClientBundle\Model\FundsOrigin;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FundsOriginFactory.
 */
class FundsOriginFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function configureData(OptionsResolver $resolver): void
    {
        $availableCodeOrigin = $this->getReferentialCodes(ReferentialHandler::REFERENTIAL_FUND_ORIGIN_CODES);
        $availableDetailCode = $this->getSubReferentialCode(ReferentialHandler::REFERENTIAL_FUND_ORIGIN_CODES, ReferentialHandler::REFERENTIAL_FUND_ORIGINS_DETAILS);

        $resolver
            ->setRequired('codeOrigin')->setAllowedTypes('codeOrigin', ['string'])->setAllowedValues('codeOrigin', $availableCodeOrigin)
            ->setDefined('detail')->setAllowedTypes('detail', ['string'])->setAllowedValues('detail', $availableDetailCode)
            ->setRequired('amount')->setAllowedTypes('amount', ['float', 'int'])
            ->setDefined('date')->setAllowedTypes('date', ['\DateTime', 'string'])->setNormalizer('date', function (Options $options, $value) {
                if ($value instanceof \DateTime) {
                    return $value;
                }

                return \DateTime::createFromFormat('d/m/Y', $value);
            })
            ->setDefined('precision')->setAllowedTypes('precision', ['string'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function doCreate(array $resolvedData)
    {
        $fundsOrigin = (new FundsOrigin())
            ->setAmount($resolvedData['amount'])
            ->setCodeOrigin($resolvedData['codeOrigin'])
        ;
        if (isset($resolvedData['detail'])) {
            $fundsOrigin->setDetail($resolvedData['detail']);
        }
        if (isset($resolvedData['date'])) {
            $fundsOrigin->setDate($resolvedData['date']);
        }

        if (isset($resolvedData['precision'])) {
            $fundsOrigin->setPrecision($resolvedData['precision']);
        }

        return $fundsOrigin;
    }
}
