<?php

namespace Modules\System\Repositories;

/**
 * Class SystemRepository
 * @package Modules\System\Repositories
 */
class SystemRepository
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $config;

    /**
     * SystemRepository constructor.
     */
    public function __construct()
    {
        $this->config = config('netcore.module-system');
    }


}