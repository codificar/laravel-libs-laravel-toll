@extends('layout.master')

@section('breadcrumbs')
<div class="row page-titles">
	<div class="col-md-6 col-8 align-self-center">
		<h3 class="text-themecolor m-b-0 m-t-0">{{ trans('toll::toll.toll_settings') }}</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
			<li class="breadcrumb-item active">{{ trans('toll::toll.toll_settings') }}</li>
		</ol>
	</div>
</div>	
@stop

@section('content')
<div id="toll" style="width: 99%;">
    <settings 
        istollactive="{{ $is_toll_active }}" 
        applytollinestimate="{{ $apply_toll_in_estimate }}" 
    />
</div>
@stop

@section('javascripts')
<script src="/toll/lang.trans/toll"> </script> 
<script src="{{ elixir('vendor/codificar/toll/toll.vue.js') }}"> </script> 
@endsection