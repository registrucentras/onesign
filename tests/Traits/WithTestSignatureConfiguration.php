<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Tests\Traits;

use RegistruCentras\OneSign\Entity\SignatureConfiguration;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\Metadata;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\HiddenPosition;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\AbsolutePosition;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\NamedPosition;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\RelativePosition;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\RelativePosition\RelativeX;
use RegistruCentras\OneSign\Entity\SignatureConfiguration\DisplayProperties\RelativePosition\RelativeY;

trait WithTestSignatureConfiguration
{
    public static function setUpTestEmptySignatureConfiguration(): SignatureConfiguration
    {
        return (new SignatureConfiguration())
            ;
    }

    public static function setUpTestSignatureConfigurationWithMetadata(): SignatureConfiguration
    {

        $metadata = (new Metadata())
            ->setReason('Fake reason')
            ->setLocation('Vilnius')
            ->setContact('Registų centras')
            ;

        return (new SignatureConfiguration())
            ->setMetadata($metadata)
            ;
    }

    public static function setUpTestSignatureConfigurationWithHiddenPosition(): SignatureConfiguration
    {

        $hiddenPosition = new HiddenPosition();

        return (new SignatureConfiguration())
            ->setDisplayProperties($hiddenPosition)
            ;
    }

    public static function setUpTestSignatureConfigurationWithRelativePositionInLeftAndTop(): SignatureConfiguration
    {

        $relativePosition = (new RelativePosition())
            ->setPage(1)
            ->setX(RelativeX::LEFT)
            ->setY(RelativeY::TOP)
            ->setWidth('8cm')
            ->setHeight('4cm')
            ;

        return (new SignatureConfiguration())
            ->setDisplayProperties($relativePosition)
            ;
    }

    public static function setUpTestSignatureConfigurationWithRelativePositionInCenter(): SignatureConfiguration
    {

        $relativePosition = (new RelativePosition())
            ->setPage(1)
            ->setX(RelativeX::CENTER)
            ->setY(RelativeY::CENTER)
            ->setWidth('8cm')
            ->setHeight('4cm')
            ;

        return (new SignatureConfiguration())
            ->setDisplayProperties($relativePosition)
            ;
    }

    public static function setUpTestSignatureConfigurationWithAbsolutePosition(): SignatureConfiguration
    {

        $absolutePosition = (new AbsolutePosition())
            ->setPage(1)
            ->setX('2cm')
            ->setY('-6cm')
            ->setWidth('8cm')
            ->setHeight('4cm')
            ;

        return (new SignatureConfiguration())
            ->setDisplayProperties($absolutePosition)
            ;
    }

    public static function setUpTestSignatureConfigurationWithNamedPosition(): SignatureConfiguration
    {

        $namedPosition = (new NamedPosition())
            ->setFieldName('signature1')
            ;

        return (new SignatureConfiguration())
            ->setDisplayProperties($namedPosition)
            ;
    }
}
