<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
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
     * @var array
     */
    private $columns;

    /**
     * SystemController constructor.
     */
    public function __construct()
    {
        $this->config = config('netcore.module-system');

        $this->columns = [
            'id',
            'type',
            'user_id',
            'message',
            'method',
            'url',
            'ip',
            'browser',
            'platform',
            'created_at',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sysInfo = core()->systemInfo();

        $columns = [];

        foreach ($this->columns as $column) {
            if (in_array($column, array_keys($this->config['columns']))) {
                if ($this->config['columns'][$column]) {
                    $columns[] = (object)[
                        'data'       => $column,
                        'name'       => $column,
                        'searchable' => $column !== 'user_id' ? true : false,
                        'orderable'  => $column !== 'user_id' ? true : false
                    ];
                }
            } else {
                $columns[] = (object)[
                    'data'       => $column,
                    'name'       => $column,
                    'searchable' => $column !== 'user_id' ? true : false,
                    'orderable'  => $column !== 'user_id' ? true : false
                ];
            }
        }

        foreach ($this->config['custom_columns'] as $column => $title) {
            $columns[] = (object)[
                'data' => $column,
                'name' => $column,
            ];
        }

        $columns = collect($columns);

        $parsedLogFiles = [];
        $logFiles = array_diff(scandir(storage_path('logs')), array('..', '.', '.gitignore', '.gitkeep'));

        foreach ($logFiles as $logFile) {
            $parsedLogFiles[] = (object)[
                'name'    => $logFile,
                'content' => tailCustom(storage_path('logs/' . $logFile), 2000)
            ];
        }

        $parsedLogFiles = collect($parsedLogFiles);

        $systemBlockCount = 0;
        if ($this->config['system-info']['cpu']) {
            $systemBlockCount++;
        }
        if ($this->config['system-info']['disk']) {
            $systemBlockCount++;
        }
        if ($this->config['system-info']['ram']) {
            $systemBlockCount++;
        }
        if ($this->config['system-info']['network']) {
            $systemBlockCount++;
        }

        $systemBlockClass = 'col-md-' . (12 / $systemBlockCount);

        return view('system::index', compact('sysInfo', 'columns', 'parsedLogFiles', 'systemBlockClass'));
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
    public function pagination(Request $request)
    {
        $columns = $this->columns;

        foreach ($this->config['custom_columns'] as $column => $title) {
            if (!in_array($column, $columns)) {
                $columns[] = $column;
            }
        }

        foreach ($this->config['columns'] as $column => $value) {
            if (isset($columns[$column])) {
                if (!$value) {
                    unset($columns[$column]);
                }
            }
        }

        $query = SystemLog::select($columns)->with('user')->orderBy('id', 'desc');

        if ($request->get('range_from') && $request->get('range_to')) {
            $query = $query->whereDate('created_at', '>=', $request->get('range_from'))
                ->whereDate('created_at', '<=', $request->get('range_to'));
        }

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

        return response()->json(['status' => 'success', 'data' => $systemLog->data]);
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
