@extends('layouts.admin')

@section('title', 'Tambah Fasilitas - Admin Kampung Adat')
@section('eyebrow', 'Fasilitas')
@section('page_title', 'Tambah Fasilitas')
@section('meta_description', 'Tambah data fasilitas publik baru di Kampung Adat Sijunjung.')

@section('content')
    @include('admin.fasilitas._form')
@endsection
