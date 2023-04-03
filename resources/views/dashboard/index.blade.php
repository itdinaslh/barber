@extends('shared.master')

@section('title', 'Dashboard')
@section('classcontent', 'content')

@section('PageHeader', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div>
                        <img src="{{ asset('/img/bg-mb.png') }}" style="margin-left:auto;margin-right:auto;"
                            class="img img-responsive" alt="logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
