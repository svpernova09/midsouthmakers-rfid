@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Member Connect</div>

                <div class="panel-body">
                    Connect your website account an RFID Door Token
                    <form class="form-horizontal" role="form" method="POST" action="/member-connect">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="key" class="col-md-4 control-label">RFID Key</label>
                            <div class="col-md-6">
                                <input type="text" name="key" value="{{ old('key') }}" placeholder="key" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pin" class="col-md-4 control-label">PIN</label>
                            <div class="col-md-6">
                                <input type="password" name="pin" value="" placeholder="pin" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
