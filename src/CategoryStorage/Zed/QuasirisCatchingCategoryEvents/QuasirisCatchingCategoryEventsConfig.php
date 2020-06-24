<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Quasiris\Zed\QuasirisCatchingCategoryEvents;

use Synchronization\SynchronizationConfig;
use Spryker\Zed\CategoryStorage\CategoryStorageConfig as SprykerCategoryStorageConfig;

use Quasiris\Zed\QuasirisCatchingCategoryEvents\Shared\QuasirisCatchingCategoryEventsConstants;


class QuasirisCatchingCategoryEventsConfig extends SprykerCategoryStorageConfig
{

    public function getMySetting(): array
    {
        return $this->get(QuasirisCatchingCategoryEventsConstants::MY_SETTING);
    }
    /**
     * @return string|null
     */
    public function getCategoryTreeSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }

    /**
     * @return string|null
     */
    public function getCategoryNodeSynchronizationPoolName(): ?string
    {
        return SynchronizationConfig::DEFAULT_SYNCHRONIZATION_POOL_NAME;
    }
}
