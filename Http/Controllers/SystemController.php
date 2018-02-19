<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\System\Models\SystemLog;
use Yajra\DataTables\Facades\DataTables;

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
        $sysInfo = core()->systemInfo();

        return view('system::index', compact('sysInfo'));
    }

    /**
     * @param SystemLog $system
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(SystemLog $system)
    {
        $system->delete();

        return response()->json(['status' => 'success']);
    }

    /**
     * @return mixed
     */
    public function pagination()
    {
        $columns = [
            'id',
            'user_id',
            'type',
            'message',
            'url',
            'method',
            'ip',
            'browser',
            'platform',
            'created_at',
        ];

        foreach ($this->config['columns'] as $column => $value) {
            if (isset($columns[$column])) {
                if (!$value) {
                    unset($columns[$column]);
                }
            }
        }

        $query = SystemLog::select($columns)->with('user')->orderBy('id', 'desc');

        $datatable = DataTables::of($query)
            ->editColumn('user_id', function ($entry) {
                if ($entry->user) {
                    return $entry->user->first_name . ' ' . $entry->user->last_name;
                } else {
                    return '-';
                }
            });

        if ($this->config['columns']['type']) {
            $datatable->editColumn('type', function ($entry) {
                return view('system::_tds.type', compact('entry'))->render();
            });
        }

        $datatable->addColumn('action', function ($entry) {
            return view('system::_tds.actions', compact('entry'))->render();
        });

        return $datatable->rawColumns(['action', 'type'])
            ->make(true);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewData($id)
    {
        $systemLog = SystemLog::findOrFail($id);

        return view('system::_partials.data', [
            'data' => $systemLog->data
        ]);
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
