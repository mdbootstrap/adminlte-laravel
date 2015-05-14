<?php
 /*
 * This file is part of the Monolog package.
 *
 * (c) Marco Bunge <marco_bunge@web.de>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Date: 26.02.2015
 * Time: 20:28
 */

 $loader = require __DIR__ . "/../vendor/autoload.php";
 $loader->addPsr4('VendorName\\PackageName\\Tests', __DIR__.'/PackageName');

 date_default_timezone_set('UTC');
