@extends('admin::layouts.master')

@section('content')
    @if(config('netcore.module-system.server-info'))
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">System Information</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-4">
                            <div class="box bg-info">
                                <div class="box-cell p-a-3 valign-middle">
                                    <i class="box-bg-icon middle right fa fa-tachometer"></i>
                                    <span class="font-size-24"><strong>{{ $sysInfo->cpu }}%</strong></span><br>
                                    <span class="font-size-15">CPU Usage</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="box bg-danger">
                                <div class="box-cell p-a-3 valign-middle">
                                    <i class="box-bg-icon middle right fa fa-hdd-o"></i>
                                    <span class="font-size-24"><strong>{{ $sysInfo->disk->free }}
                                            /{{ $sysInfo->disk->total }}</strong></span><br>
                                    <span class="font-size-15">Disk Usage</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="box bg-success">
                                <div class="box-cell p-a-3 valign-middle">
                                    <i class="box-bg-icon middle right fa fa-server"></i>
                                    <span class="font-size-24"><strong>{{ $sysInfo->ram }} %</strong></span><br>
                                    <span class="font-size-15">Memory Usage</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Logs</h4>
                </div>
                <div class="panel-body">
                    <div class="table-primary">
                        <table class="table table-bordered datatable">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Method</th>
                                <th>IP</th>
                                <th>Browser</th>
                                <th>Platform</th>
                                <th style="min-width:200px">Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(config('netcore.module-system.php-info'))
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">PHP Info</h4>
                    </div>
                    <div class="panel-body">
                        <iframe src="{{ route('admin::system.phpinfo') }}"
                                style="width:100%;height:500px;border: 0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin::portfolio.pagination') !!}',
            responsive: true,
            order: [[5, "desc"]], // created_at
            columns: [

                /**
                 * data is used to display data that come from server,
                 * but 'name' is sent to server when we need to do sorting/searching
                 */
                {data: 'title', name: 'title'},
                {data: 'slug', name: 'slug'},
                {data: 'content', name: 'content', orderable: false},
                {data: 'has_feedback', name: 'has_feedback', orderable: false, searchable: false},
                {data: 'is_visible', name: 'is_visible'},
                {data: 'in_homepage', name: 'in_homepage'},
                {data: 'type', name: 'type'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#datatable_wrapper .table-caption').text('');
        $('#datatable_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

    </script>
@endsection
