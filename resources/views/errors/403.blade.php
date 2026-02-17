@extends('errors.minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __('غير مصرح لك'))
@section('description', 'عذراً، ليس لديك الصلاحية للوصول إلى هذه الصفحة.')

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-amber-600 opacity-80" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
    </svg>
@endsection
