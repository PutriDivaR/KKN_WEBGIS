@extends('layouts.admin')

@section('title', 'Tambah Rumah Adat — ' . ($stepTitles[$currentStep]['label'] ?? 'Informasi'))
@section('eyebrow', 'Rumah Adat')
@section('page_title', 'Tambah Rumah Adat - ' . ($stepTitles[$currentStep]['label'] ?? 'Informasi'))

@section('content')
	@include('admin.rumah._form', [
		'mode' => 'create',
		'activeStep' => $currentStep,
		'action' => route('admin.rumah.store'),
		'method' => 'POST',
		'rumahId' => null,
		'draftId' => $draftId ?? null,
	])
@endsection