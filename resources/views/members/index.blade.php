@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Members</div>

                    <div class="card-body">
                        <a href="{{ url('/members/create') }}">
                            <button class="btn btn-primary">Create Member</button>
                        </a>
                        Changes made here are not immediately affected and may take an hour
                        to be reflected at the space.
                    </div>
                    <div class="table-responsive">
                        <table id="members" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Key</th>
                                <th>IRC Name</th>
                                <th>Spoken Name</th>
                                <th>Admin</th>
                                <th>Active</th>
                                <th>Date Created</th>
                                <th>Last Login</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                @if($member->active)
                                    @if($member->admin)
                                        <tr class="table-success">
                                    @else
                                        <tr>
                                    @endif
                                @else
                                    <tr class="table-danger">
                                        @endif


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
                                        <td>{{ $member->last_login }}</td>
                                        <td>
                                            <a href="/members/{{ $member->id }}/edit">
                                                <button type="button" class="btn btn-primary">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </button>
                                            </a>
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
