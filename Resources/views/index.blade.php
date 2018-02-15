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
                                    <span class="font-size-24"><strong>0%</strong></span><br>
                                    <span class="font-size-15">CPU Usage</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="box bg-danger">
                                <div class="box-cell p-a-3 valign-middle">
                                    <i class="box-bg-icon middle right fa fa-hdd-o"></i>
                                    <span class="font-size-24"><strong>0%</strong></span><br>
                                    <span class="font-size-15">Disk Usage</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="box bg-success">
                                <div class="box-cell p-a-3 valign-middle">
                                    <i class="box-bg-icon middle right fa fa-server"></i>
                                    <span class="font-size-24"><strong>0%</strong></span><br>
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
                        <iframe src="{{ route('admin::system.phpinfo') }}" style="width:100%;height:500px;border: 0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')

@endsection
