@extends('admin.layouts.master')
@section('title', __('cabbooking::static.documents.add_document'))
@section('content')
    <div class="document-main">
        <form id="documentForm" action="{{ route('admin.document.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('cabbooking::admin.document.fields')
        </form>
    </div>
@endsection
