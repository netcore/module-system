@extends('admin::layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('/assets/system/css/jquery.json-viewer.css') }}">
@append

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
                                    <span class="font-size-24">
                                        <strong>{{ $sysInfo->disk->free }}/{{ $sysInfo->disk->total }}</strong>
                                    </span>
                                    <br>
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
                                <th>Actions</th>
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
@endsection

@section('scripts')
    <script src="{{ asset('/assets/system/js/jquery.json-viewer.js') }}"></script>

    <script>
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin::system.pagination') !!}',
            responsive: true,
            order: [[0, "desc"]], // created_at
            columns: [
                {data: 'id', name: 'id'},
                    @if(config('netcore.module-system.columns.type'))
                {
                    data: 'type', name: 'type'
                },
                    @endif
                {
                    data: 'user_id', name: 'user_id', orderable: false, searchable: false
                },
                {data: 'message', name: 'message'},
                {data: 'method', name: 'method'},
                {data: 'url', name: 'url'},
                    @if(config('netcore.module-system.columns.type'))
                {
                    data: 'ip', name: 'ip'
                },
                    @endif
                    @if(config('netcore.module-system.columns.browser'))
                {
                    data: 'browser', name: 'browser'
                },
                    @endif
                    @if(config('netcore.module-system.columns.platform'))
                {
                    data: 'platform', name: 'platform'
                },
                    @endif
                {
                    data: 'created_at', name: 'created_at'
                },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#datatable_wrapper .table-caption').text('');
        $('#datatable_wrapper .dataTables_filter input').attr('placeholder', 'Search...');

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
