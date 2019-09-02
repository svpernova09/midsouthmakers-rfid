@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                    @if(count(Auth::user()->members) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>IRC Name</th>
                                    <th>Spoken Name</th>
                                    <th>Admin</th>
                                    <th>Active</th>
                                    <th>Date Created</th>
                                    <th>Last Login</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(Auth::user()->members as $member)
                                    <tr>
                                        <td>{{ $member->key }}</td>
                                        <td>{{ $member->irc_name }}</td>
                                        <td>{{ $member->spoken_name }}</td>
                                        <td>
                                            @if($member->admin)
                                                <i class="fas fa-user-cog"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($member->active)
                                                <i class="fas fa-plus"></i>
                                            @else
                                                <i class="fas fa-minus"></i>
                                            @endif
                                        </td>
                                        <td>{{ $member->date_created }}</td>

                                        @if($member->login_attemps)
                                            <td>{{ $member->last_login_record }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    @endif
                </div>
                <div class="card-body">
                    @if(Auth::user()->admin)
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
