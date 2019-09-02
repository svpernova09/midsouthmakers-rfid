@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create Member</div>

                    <div class="card-body">
                        <div class="alert-danger">
                            <span class="fab fa-warning-sign"></span>
                            This works in <strong>theory</strong>. But has not yet been real world tested. Proceed with Caution.
                            Worst case: user will not work and will need to be deleted.
                            <span class="fab fa-warning-sign"></span>
                        </div>
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
                                    <label for="irc_name">IRC/Nick Name</label>
                                    <input type="text" class="form-control" name="irc_name" placeholder="IRC/Nick Name" value="{{ old('irc_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="spoken_name">Name</label>
                                    <input type="text" class="form-control" name="spoken_name" placeholder="Name" value="{{ old('spoken_name') }}">
                                </div>
                                <div class="checkbox">
                                    Is Admin
                                    <label class="radio-inline"><input type="radio" name="admin" value="1">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="admin" value="0" checked>No</label>
                                </div>
                                <div class="checkbox">
                                    Is Active
                                    <label class="radio-inline"><input type="radio" name="active" value="1" checked="checked">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="active" value="0">No</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
