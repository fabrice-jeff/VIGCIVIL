<?php

namespace App\Twig\Runtime;

use App\Repository\StatusRepository;
use App\Utils\Constants\FixedValuesConstants;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(private StatusRepository $statusRepository)
    {
        // Inject dependencies if needed
    }

    public function doSomething($value)
    {
        // ...
    }

    public function colorStatus($status){
        switch ($status->getReference()){
            case  FixedValuesConstants::STATUS_DEMANDE_SOUMISE :
                return 'warning';
            case  FixedValuesConstants::STATUS_DEMANDE_REJETEE || FixedValuesConstants::STATUS_DEMANDE_ANNULEE :
                return 'danger';
            case FixedValuesConstants::STATUS_DEMANDE_VALIDEE:
                return 'success';
                default:
                    return 'default';
        }
    }
}
