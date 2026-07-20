@extends('layouts.admin')

@section('title', 'Edit Fasilitas - Admin Kampung Adat')
@section('eyebrow', 'Fasilitas')
@section('page_title', 'Edit Fasilitas')
@section('meta_description', 'Perbarui data fasilitas publik di Kampung Adat Sijunjung.')

@section('content')
    @include('admin.fasilitas._form')
@endsection
