@extends('errors.minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('الصفحة غير موجودة'))
@section('description', 'عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.')

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-amber-500 opacity-80" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@endsection
