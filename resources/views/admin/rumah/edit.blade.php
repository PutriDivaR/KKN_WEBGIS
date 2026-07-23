@extends('layouts.admin')

@section('title', 'Edit Rumah Adat')
@section('eyebrow', 'Rumah Adat')
@section('page_title', 'Edit Rumah Adat')

@section('content')

@include('admin.rumah._form',[
    'mode'=>'edit',
    'action'=>route('admin.rumah.update',$rumahId),
    'method'=>'PUT',
    'rumahId'=>$rumahId,
])

@endsection