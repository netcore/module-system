@extends('admin::layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('/assets/system/css/jquery.json-viewer.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
@append

@section('content')
    @if(config('netcore.module-system.server-info.enabled'))
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">System Information</h4>
                    </div>
                    <div class="panel-body">
                        @if(config('netcore.module-system.server-info.cpu'))
                            <div class="{{ $systemBlockClass }}">
                                <div class="box bg-info">
                                    <div class="box-cell p-a-3 valign-middle">
                                        <i class="box-bg-icon middle right fa fa-tachometer"></i>
                                        <span class="font-size-24"><strong>{{ $sysInfo->cpu }}%</strong></span><br>
                                        <span class="font-size-15">CPU Usage</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(config('netcore.module-system.server-info.disk'))
                            <div class="{{ $systemBlockClass }}">
                                <div class="box bg-danger">
                                    <div class="box-cell p-a-3 valign-middle">
                                        <i class="box-bg-icon middle right fa fa-hdd-o"></i>
                                        <span class="font-size-24">
                                    <strong>{{ $sysInfo->disk->free }}/{{ $sysInfo->disk->total }}</strong>
                                </span>
                                        <br>
                                        <span class="font-size-15">Disk Usage</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(config('netcore.module-system.server-info.disk'))
                            <div class="{{ $systemBlockClass }}">
                                <div class="box bg-success">
                                    <div class="box-cell p-a-3 valign-middle">
                                        <i class="box-bg-icon middle right fa fa-server"></i>
                                        <span class="font-size-24"><strong>{{ $sysInfo->ram->percent }} %</strong></span><br>
                                        <span class="font-size-15">Memory Usage: <small>{{ $sysInfo->ram->used }}/{{ $sysInfo->ram->total }}</small></span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(config('netcore.module-system.server-info.disk'))
                                <div class="{{ $systemBlockClass }}">
                                    <div class="box bg-warning">
                                        <div class="box-cell p-a-3 valign-middle">
                                            <i class="box-bg-icon middle right fa fa-globe"></i>
                                            <span class="font-size-20"><strong>{{ $sysInfo->network->in }} | {{ $sysInfo->network->out }}</strong></span><br>
                                            <span class="font-size-15">Network Usage</span>
                                        </div>
                                    </div>
                                </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">System Logs</h4>
                </div>
                <div class="panel-body">
                    <div class="table-primary">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                @if(config('netcore.module-system.columns.type'))
                                    <th>Type</th>
                                @endif
                                <th>User</th>
                                <th>Message</th>
                                <th>Method</th>
                                <th>URL</th>
                                @if(config('netcore.module-system.columns.ip'))
                                    <th>IP</th>
                                @endif
                                @if(config('netcore.module-system.columns.browser'))
                                    <th>Browser</th>
                                @endif
                                @if(config('netcore.module-system.columns.platform'))
                                    <th>Platform</th>
                                @endif
                                <th>Created At</th>

                                @foreach(config('netcore.module-system.custom_columns') as $column => $title)
                                    <th>{{ $title }}</th>
                                @endforeach

                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(config('netcore.module-system.log-files'))
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Log Files</span>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            @foreach($parsedLogFiles as $key => $logFile)
                                <li class="{{ $loop->first ? 'active' : '' }}">
                                    <a href="#log-file-{{ $key }}" data-toggle="tab" aria-expanded="true">
                                        {{ $logFile->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content tab-content-bordered">
                            @foreach($parsedLogFiles as $key => $logFile)
                                <div class="tab-pane fade in {{ $loop->first ? 'active' : '' }}"
                                     id="log-file-{{ $key }}">
                                    <div style="height:300px;overflow-y: auto">
                                        {!! nl2br($logFile->content) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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

    <div id="view-data" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Data</h4>
                </div>
                <div class="modal-body">
                    <div id="json-renderer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <input id="column-json" type="hidden" value="{{ $columns->toJson() }}">
    <input id="range-from" type="hidden" value="">
    <input id="range-to" type="hidden" value="">
@endsection

@section('scripts')
    <script src="{{ asset('/assets/system/js/jquery.json-viewer.js') }}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

    <script>
        var columns = JSON.parse(jQuery('#column-json').val());

        columns.push({
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        });

        var table = jQuery('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('admin::system.pagination') !!}',
                data: function (d) {
                    d.range_from = jQuery('#range-from').val();
                    d.range_to = jQuery('#range-to').val();
                }
            },
            responsive: true,
            order: [[0, "desc"]], // created_at
            columns: columns
        });

        jQuery('#datatable_wrapper .table-caption').html('Range: <input type="text" class="form-control daterange" style="width:200px">');
        jQuery('#datatable_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

        jQuery('.daterange').daterangepicker(
            {
                locale: {
                    format: 'YYYY-MM-DD'
                }
            },
            function (start, end, label) {
                jQuery('#range-from').val(start.format('YYYY-MM-DD'));
                jQuery('#range-to').val(end.format('YYYY-MM-DD'));

                table.ajax.reload();
            });

        jQuery(document).on('click', '.view-data', function (e) {
            e.preventDefault();

            var self = jQuery(this);

            var id = self.data('id');
            var text = self.html();

            self.html('<i class="fa fa-refresh fa-spin"></i>');
            self.attr('disabled', true);

            jQuery.get('{{ url('admin/system/view-data') }}/' + id, function (response) {
                jQuery('#json-renderer').jsonViewer(response.data);

                jQuery('#view-data').modal('show');

                self.html(text);
                self.attr('disabled', false);
            })
        });
    </script>
@endsection
