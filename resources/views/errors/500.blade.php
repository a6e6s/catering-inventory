@extends('errors.minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('خطأ في الخادم'))
@section('description', 'حدث خطأ غير متوقع في الخادم. نعتذر عن الإزعاج، يرجى المحاولة لاحقاً.')

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-red-500 opacity-80" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@endsection
