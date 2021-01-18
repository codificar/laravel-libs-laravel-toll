<script>

export default {
	inject: ['fetch','Modal'],
	data() {
		return {
			tollCategory_filter:{
				name:"",
			},
		}
	},
	methods:{
		filter: function(){
			this.$parent.tollsCategory =  this.fetch(1, this.tollCategory_filter);
		},
		openModal:function(){
			this.$parent.modal(true,false);
		},
		clearForm(){
			this.tollCategory_filter.name = "";
			this.$parent.tollsCategory =  this.fetch(1, this.tollCategory_filter);
		},
	}
}
</script>
<template>
	<!-- Row -->
	<div class="tab-content">
		<div class="row">
			<div class="col-md-12">
				<button  class="btn pull-right hidden-sm-down btn-success mb-4 mr-4" id="show-modal" @click="openModal()">{{trans('toll.toll_category_add')}} </button>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="card card-outline-info">
				<div class="card-header">
					<div class="row">
						<div class="col-md-8 col-sm-12">
							<h4 class="m-b-0 text-white">{{trans('toll.filters')}}</h4>
						</div>
					</div>
				</div>
				<div class="card-block">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<!--Name-->
							<div class="form-group">
								<label for="name" class=" control-label">{{ trans('toll.name') }}*</label>
								<input v-model="tollCategory_filter.name" name="name" type="text" id="name" class="form-control input-lg" maxlenght="255" auto-focus="" :placeholder="trans('toll.name')">
							</div>
						</div>
					</div>
					<!-- Action -->
					<div class="form-group">
						<div class="pull-right">
							<div class="col-md-6 col-md-offset-4">
								<button type="button" @click="filter()" class="btn btn-success">
								<i class="fa fa-search"></i> {{trans('toll.filter')}}
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>







