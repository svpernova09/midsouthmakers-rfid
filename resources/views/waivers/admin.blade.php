@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Signed Waviers</div>

                    <div class="card-body">
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
                                                <i class="fas fa-download"></i>
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
