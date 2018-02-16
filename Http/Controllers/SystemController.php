<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

/**
 * Class SystemController
 * @package Modules\System\Http\Controllers
 */
class SystemController extends Controller
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $config;

    /**
     * SystemController constructor.
     */
    public function __construct()
    {
        $this->config = config('netcore.module-system');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sysInfo = (object)[
            'disk' => (object)[
                'total' => formatBytes(disk_total_space('/')),
                'free' => formatBytes(disk_total_space('/') - disk_free_space('/'))
            ],
            'ram' => round(serverMemoryUsage(), 2),
            'cpu' => systemLoad(systemCoreCount())
        ];

        return view('system::index', compact('sysInfo'));
    }


    /**
     * Get PHP Info
     */
    public function phpInfo()
    {
        if ($this->config['php-info']) {
            phpinfo();
        }
    }
}
