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
        return view('system::index');
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
