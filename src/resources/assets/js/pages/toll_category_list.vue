<script>
import axios from "axios";
import resource from "resource-axios";
import tollCategoryFilter from './toll_category_filter';
import tollCategoryModal from './toll_category_modal';

const tollCategory = resource('/api/lib/toll_categories', {
  search: (searchParams) => axios.post("/api/lib/toll_category/fetch",{searchParams})
}, axios);

export default {
	props: ["EditPermission","DeletePermission"],
	provide: function () {
		return {
			fetch: this.fetch,
			Modal: this.modal,
			closeModal: this.closeModal,
			save:this.save,
		}
	},
	data() {
		return {
			searchParams :{
			sort:[],
			pagination:{
				actual:0,
				itensPerPage:10,
			},
			filters:{
				Categoryfilter:{},
				ItensPerPage:10
			},
			embed: 'Project',
			},
			tollsCategory: {},
			tollCategory_filter:{},
			edit:false,
			showModal:false,
			editTollCategory:{},
		};
	},
	methods: {
		fetch(page = 1,tollCategory_filter) {
			var component = this;
			component.searchParams.pagination.actual = page;
			component.searchParams.filters.Categoryfilter = tollCategory_filter;
			tollCategory.search(component.searchParams)
			.then((response) => {
				component.tollsCategory = response.data;
			});
			this.$nextTick();
		},
		save:function(formTollCategory){
			return tollCategory.save({
				id : formTollCategory.id,
				name: formTollCategory.name,
				editMode: formTollCategory.editMode
			});
		},
		modal:function(modal,edit,tollCategory){
			this.showModal=modal;
			this.edit=edit;
			this.editTollCategory = tollCategory;
		},
		closeModal:function(){
			this.showModal=false;
		},
		deleteTollCategory(id, name) {
			this.$swal({
				title: this.trans('toll.toll_category_delete_confirm'),
				text: name,
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: this.trans('toll.yes'),
				cancelButtonText: this.trans('toll.no')
				}).then((result) => {
				if (result.value) {
					//Try to remove and show fail mission if fails
					tollCategory.delete(id)
					.then(
						response => {
							this.fetch();
						},
						response => {
							this.$swal({
								title: this.trans('toll.delete_failed'),
								type: 'error'
							});
							console.log(response);
							// error callback
						}
					);
				}
			});
		}
	},
	created() {
		this.fetch(1,this.tollCategory_filter);
	},
	components:{
		appTollCategoryFilter : tollCategoryFilter,
		appTollCategoryModal : tollCategoryModal,
	}
};
</script>
<template>
	<div>
		<app-toll-category-filter></app-toll-category-filter>
		<div class="tab-content">
			<div class="col-lg-12">
				<div class="card card-outline-info">
					<div class="card-block">
						<table class="table">
							<!-- <th>{{trans('institution.id')}}</th> -->
							<th>{{trans('toll.id')}}</th>
							<th>{{trans('toll.name')}}</th>
							<th>{{trans('toll.action_grid')}}</th>
							<tbody>
								<tr v-for="tollCategory in tollsCategory.data" v-bind:key="tollCategory.id">
									<td>{{ tollCategory.attributes.id }}</td>
									<td>{{ tollCategory.attributes.name }}</td>
									<td>
										<div class="dropdown">
											<button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
												{{trans('toll.action_grid') }}
												<span class="caret"></span>
											</button>
											<div class="dropdown-menu dropdown-menu-center" role="menu" aria-labelledby="dropdownMenu1">
												 <!-- EDITAR -->
												<button v-if="EditPermission" class="dropdown-item" tabindex="-1" id="show-modal-edit" @click="modal(true,true,tollCategory.attributes)" type="button">{{trans('toll.edit')}} </button>
												 <!-- DELETAR -->
												<button v-if="DeletePermission"  type="button" class="dropdown-item" v-on:click="deleteTollCategory(tollCategory.attributes.id, tollCategory.attributes.name)" tabindex="-1" >{{trans('toll.delete')}} </button>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<pagination :data="tollsCategory" @pagination-change-page="fetch"></pagination>
			</div>
			<app-toll-category-modal v-if="showModal" :modeEdit="edit" :tollCategory="editTollCategory"></app-toll-category-modal>
		</div>
	</div>
</template>
