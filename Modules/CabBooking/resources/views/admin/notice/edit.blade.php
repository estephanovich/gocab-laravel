@extends('admin.layouts.master')
@section('title', __('cabbooking::static.notices.edit'))
@section('content')
<div class="notice-main">
    <form id="noticeForm" action="{{ route('admin.notice.update', $notice->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('cabbooking::admin.notice.fields')
    </form>
</div>
@endsection
