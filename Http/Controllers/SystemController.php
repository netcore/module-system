<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('system::index');
    }

}
