@extends('admin.layouts.master')
@section('title', __('cabbooking::static.documents.edit'))
@section('content')
<div class="document-main">
    <form id="documentForm" action="{{ route('admin.document.update', $document->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('cabbooking::admin.document.fields')
    </form>
</div>
@endsection
