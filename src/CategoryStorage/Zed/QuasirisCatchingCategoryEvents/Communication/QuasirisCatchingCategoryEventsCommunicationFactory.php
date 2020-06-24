<?php

namespace Quasiris\Zed\QuasirisCatchingCategoryEvents\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Quasiris\Zed\QuasirisCatchingCategoryEvents\QuasirisCatchingCategoryEventsDependencyProvider;


class QuasirisCatchingCategoryEventsCommunicationFactory extends AbstractCommunicationFactory
{
    public function getProductFacede() {
        return $this->getProvidedDependency(QuasirisCatchingCategoryEventsDependencyProvider::FACADE_PRODUCT);
    }
    public function getLocaleFacede() {
        return $this->getProvidedDependency(QuasirisCatchingCategoryEventsDependencyProvider::FACADE_LOCALE);
    }


}

