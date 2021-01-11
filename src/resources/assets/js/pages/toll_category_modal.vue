<script>
import axios from "axios";
export default {
	inject: ['closeModal','fetch','save'],
	props: ["tollCategory","modeEdit"],
	data() {
		return{
			editMode: false,
			formTollCategory:{
				name:"",
				editMode: this.modeEdit,
				id: this.editMode == true ? this.tollCategory.id : 0,
			},
			msg:"",
			danger:false,
			success:false,
		}
	},
	methods: {
		saveForm:function(){
			let currentObj = this;
			currentObj.formTollCategory.id = this.editMode == true ? this.tollCategory.id : 0;
			this.save(currentObj.formTollCategory).then(
				response => {
					if(response.data.success == false){
						this.$swal({
						title: this.trans(''+response.data.errors[0]+''),
						timer: 2500,
						showConfirmButton: false,
						type: 'error'
						});
					} else {
						this.fetch();
						this.$swal({
						title: currentObj.formTollCategory.id = this.editMode == true?this.trans('toll.edit_success'):this.trans('toll.add_success'),
						timer: 2500,
						showConfirmButton: false,
						type: 'success'
						});
						setTimeout(function(){
								currentObj.modalClose();
						},3000);
					}
				},
				response => {
					this.$swal({
						title: currentObj.formTollCategory.id = this.editMode == true?this.trans('toll.edit_fail'):this.trans('toll.add_fail'),
						timer: 2500,
						showConfirmButton: false,
						type: 'error'
					});
					console.log(response);
					// error callback
				}
			)
		},
		modalClose:function(){
			this.$parent.closeModal();
		}
	},
	created(){
		this.editMode = this.modeEdit;
		if(this.editMode == true){
			this.formTollCategory.name = this.tollCategory.name;
		}
	}
}
</script>
<template>
<transition name="modal">
	<div class="modal-mask">
		<div class="modal-wrapper">
			<div class="modal-container">
				<div class="modal-header">
					<h5 class="modal-title" v-show="!this.editMode" id="addNewLabel">{{ trans('toll.toll_category_add') }}</h5>
					<h5 class="modal-title" v-show="this.editMode" id="addNewLabel">{{trans('toll.edit')}}</h5>
					<button type="button" class="close" data-dismiss="modal" @click="modalClose()" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<slot name="body">
						<div class="form-group">
							<label for="name" class=" control-label">{{ trans('toll.name') }}*</label>
							<input v-model="formTollCategory.name" name="name" type="text" id="name" class="form-control input-lg" maxlenght="255" auto-focus="" :placeholder="trans('toll.name')">
						</div>
					</slot>
					<div class="modal-footer">
						<div class="row">
							<div class="col-md-4 col-sm-12">
								<button type="submit"  v-on:click="saveForm()" class="btn btn-primary">{{trans('toll.send')}}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</transition>
</template>
<style scoped>
.modal-mask {
	position: fixed;
	z-index: 3;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, .5);
	display: table;
	transition: opacity .3s ease;
}

.modal-wrapper {
	display: table-cell;
	vertical-align: middle;
}

.modal-container {
	width: 550px;
	height:325px;
	margin: 0px auto;
	padding: 15px 20px;
	background-color: #fff;
	border-radius: 15px;
	box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
	transition: all .3s ease;
	font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
	margin-top: 0;
	color: #42b983;
}

.modal-body {
	margin: 20px 0;
}

.modal-default-button {
	float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
	opacity: 0;
}

.modal-leave-active {
	opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
	-webkit-transform: scale(1.1);
	transform: scale(1.1);
}

</style>