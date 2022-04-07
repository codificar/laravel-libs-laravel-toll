@extends('layout.master')

@section('breadcrumbs')
<div class="row page-titles">
    <div class="col-md-6 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">{{trans('toll::toll.toll')}}</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">{{trans('toll::toll.toll_list')}}</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div id='toll'>
    <div class="row">
        <div class="col-6 col-md-12 aling-self-end">
            <button  class="btn pull-right hidden-sm-down btn-success mb-4 mr-4" id="show-modal" @click="showModal = true">{{trans('toll::toll.toll_import')}} </button>
            <!-- use the modal component, pass in the prop -->
            <tolladd v-if="showModal" @close="showModal = false"></tolladd>
        </div>
    </div>
    <tolllist />

</div>
@stop 

@section('javascripts')
<script src="/toll/lang.trans/toll"> </script> 
<script src="{{ asset('vendor/codificar/toll/js/toll.vue.js') }}"> </script> 
@endsection