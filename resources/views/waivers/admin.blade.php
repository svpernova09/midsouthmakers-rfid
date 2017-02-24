@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Signed Waivers</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Email</th>
                                    <th>Name</th>
                                    <th>Download</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($waivers as $waiver)
                                    <tr>
                                        <td>{{ $waiver->created_at }}</td>
                                        <td>{{ $waiver->email }}</td>
                                        <td>{{ $waiver->between_name }}</td>
                                        <td>
                                            <a href="{{ url('/waivers/download', $waiver->id) }}">
                                                <span class="glyphicon glyphicon-save"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $waivers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
