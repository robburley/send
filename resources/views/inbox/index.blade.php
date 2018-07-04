@extends('layouts.app')

@section('title', 'Inbox')

@section('content')
    <email-base
            fetch_url="{{ $dataUrl }}"
            update_url="{{ $updateUrl }}"
            current_folder="{{ $folder ?? 0 }}"
    ></email-base>
@endsection