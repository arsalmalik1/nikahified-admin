<?php

declare(strict_types=1);

namespace Imdhemy\Purchases\Facades;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Imdhemy\Purchases\Subscription googlePlay(?ClientInterface $client = null)
 * @method static \Imdhemy\Purchases\Subscription appStore(?ClientInterface $client = null)
 */
class Subscription extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'subscription';
    }
}
