@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Log Viewer</div>
                    <div class="panel-body">
                        <p>
                            Logs are synced here every hour.
                        </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>IRC Name</th>
                                <th>Result</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($log_entries as $log)
                            <tr>
                                <td>{{ $log['date'] }}</td>
                                <td>{{ $log['irc_name'] }}</td>
                                <td>
                                    @if($log['result'] == 'granted')
                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                    @else
                                        <span class="glyphicon glyphicon-minus-sign"></span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
