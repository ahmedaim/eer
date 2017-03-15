@extends('admin/layout')

@section('styles')
    <link href="{{url('css/style.css')}}" rel="stylesheet" />
@stop

@section('content')

        <div class="col-md-10 content">

            <div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-list"></span>Admin Lists
                        <div class="pull-right action-buttons">
                            <div class="btn-group pull-right">
                                <a href="{{url('admin/admins/create')}}" class="btn btn-default btn-xs dropdown-toggle"  >
                                    <span class="glyphicon glyphicon-plus" style="margin-right: 0px;"></span>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(count($admins))
                        <ul class="list-group">
                            @foreach($admins as $admin)
                                <li class="list-group-item">
                                    <div class="checkbox">

                                        <label >
                                            {{ $admin->username }}
                                        </label>
                                    </div>
                                    <div class="pull-right action-buttons">
                                        <a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                </li>
                            @endforeach

                        </ul>
                        @endif
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>
                                    Page Count : <span class="label label-info">{{count($admins)}}</span></h6>
                            </div>
                            <div class="col-md-6">
                                <ul class="pagination pagination-sm pull-right">
                                    {{ $admins->links() }}

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

@stop

@section('javascripts')


@stop
