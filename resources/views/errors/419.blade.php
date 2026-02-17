@extends('errors.minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('انتهت الجلسة'))
@section('description', 'عذراً، انتهت صلاحية الجلسة. يرجى تحديث الصفحة والمحاولة مرة أخرى.')

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-500 opacity-80" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@endsection
