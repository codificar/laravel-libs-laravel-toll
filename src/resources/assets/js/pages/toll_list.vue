<template>
  <div>
        <div class="tab-content">
            <div class="col-lg-12">
                <div class="card card-outline-info">            
                    <div class="card-block">
                        <table class="table">
                            <tr>
                                <th>{{trans('toll.name')}}</th>
                                <th>{{trans('toll.highway')}}</th>
                                <th>Km</th>
                                <th>{{trans('toll.axis')}}</th>
                                <th>{{ trans('toll.description') }}</th>
                                <th>{{ trans('toll.price') }}</th>
                                <th>{{trans('toll.action_grid')}}</th>
                            </tr>      
                            <tr v-for="toll in tolls.data" v-bind:key="toll.id">
                                <td>{{ toll.name }}</td>
                                <td>{{ toll.highway }}</td>
                                <td>{{ toll.km }}</td>
                                <td>{{ toll.axis }}</td>
                                <td>{{ toll.category_description }}</td>
                                <td>{{ toll.value }}</td>
                                <td class="toll-action-col">
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                            {{trans('toll.action_grid') }}
                                            <span class="caret"></span>
                                        </button>
                                
                                        <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                                                <!-- DELETAR -->
                                            <button @click="deleteToll(toll.id, toll.name)" type="button" class="dropdown-item" tabindex="-1" >{{trans('toll.delete')}} </button> 
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            	
                        </table>
                    </div>
                </div>

                <pagination :data="tolls" @pagination-change-page="fetch"></pagination>
            </div>
        </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ["DeletePermission"],
    data() {
        return {
            tolls: [],
            toll_filter: {
                name: "",
                axis: "",
            }
        };
    },
    methods: {
        fetch(page = 1) {
            var component = this;
            axios.post("/api/lib/toll/fetch", {
                pagination: {
                    actual : page,
                    itensPerPage : 10
                },
                filters: {
                    Toll: this.toll_filter,
                    ItensPerPage: 10
                }
            })
            .then(
                response => {
                    component.tolls = response.data.toll;
                },
                response => {
                // error callback
                }
            );
            this.$nextTick();
        },
        deleteToll(id, name) {
            this.$swal({
                title: this.trans('toll.toll_delete_confirm') + " " + name + "?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('toll.yes'),
                cancelButtonText: this.trans('toll.no')
                }).then((result) => {
                if (result.value) {
                    //Try to remove and show fail mission if fails
                    axios.post("/api/lib/toll/delete/" + id).then(
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
        this.fetch();
    }
}
</script>

<style>
.toll-action-col {
    width: 100px;
}
</style>