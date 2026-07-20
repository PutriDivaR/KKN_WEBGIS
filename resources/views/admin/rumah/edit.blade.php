@extends('layouts.admin')

@section('title', 'Ubah Rumah Adat — ' . ($stepTitles[$currentStep]['label'] ?? 'Informasi'))
@section('eyebrow', 'Rumah Adat')
@section('page_title', 'Ubah Rumah Adat - ' . ($stepTitles[$currentStep]['label'] ?? 'Informasi'))

@section('content')
	@include('admin.rumah._form', [
		'mode' => 'edit',
		'activeStep' => $currentStep,
		'action' => route('admin.rumah.update', $rumahId),
		'method' => 'PUT',
		'rumahId' => $rumahId,
		'draftId' => $draftId ?? null,
	])
@endsection