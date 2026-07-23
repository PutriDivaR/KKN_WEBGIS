@extends('layouts.admin')

@section('title','Tambah Rumah Adat')

@section('content')

@include('admin.rumah._form',[
    'mode'=>'create',
    'action'=>route('admin.rumah.store'),
    'method'=>'POST',
])

@endsection