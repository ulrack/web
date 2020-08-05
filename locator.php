<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

use Ulrack\Web\Common\UlrackWebPackage;
use GrizzIt\Configuration\Component\Configuration\PackageLocator;

PackageLocator::registerLocation(
    __DIR__,
    UlrackWebPackage::PACKAGE_NAME,
    []
);
