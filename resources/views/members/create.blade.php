@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Member</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <form method="POST" action="/members">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="key">Key</label>
                                    <input type="text" class="form-control" name="key" placeholder="Key" value="{{ old('key') }}">
                                </div>
                                <div class="form-group">
                                    <label for="pin">PIN</label>
                                    <input type="text" class="form-control" name="pin" placeholder="Pin" value="{{ old('pin') }}">
                                </div>
                                <div class="form-group">
                                    <label for="ircName">IRC/Nick Name</label>
                                    <input type="text" class="form-control" name="ircName" placeholder="IRC/Nick Name" value="{{ old('ircName') }}">
                                </div>
                                <div class="form-group">
                                    <label for="spokenName">Name</label>
                                    <input type="text" class="form-control" name="spokenName" placeholder="Name" value="{{ old('spokenName') }}">
                                </div>
                                <div class="checkbox">
                                    Is Admin
                                    <label class="radio-inline"><input type="radio" name="isAdmin" value="1">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="isAdmin" value="0" checked>No</label>
                                </div>
                                <div class="checkbox">
                                    Is Active
                                    <label class="radio-inline"><input type="radio" name="isActive" value="1" checked="checked">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="isActive" value="0">No</label>
                                </div>
                                <button type="submit" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
