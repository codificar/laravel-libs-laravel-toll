<template>
  <div>
        <div class="tab-content">
            <div class="col-lg-12">
                <div class="card card-outline-info">            
                    <div class="card-block">
                        <table class="table">
                            <tr>
                                <th>{{trans('toll.name')}}</th>
                                <th>{{trans('toll.address')}}</th>
                                <th>{{trans('toll.axis')}}</th>
                                <th>{{trans('toll.action_grid')}}</th>
                            </tr>      
                            <tr v-for="toll in tolls.data" v-bind:key="toll.id">
                                <td>{{ toll.name }}</td>
                                <td>{{ toll.address }}</td>
                                <td>{{ toll.axis }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                            {{trans('toll.action_grid') }}
                                            <span class="caret"></span>
                                        </button>
                                
                                        <div class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                                                <!-- DELETAR -->
                                            <button v-if="DeletePermission" v-on:click="deleteToll(toll.id, toll.name)" type="button" class="dropdown-item" tabindex="-1" >{{trans('toll.delete')}} </button> 
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            	
                        </table>
                    </div>
                </div>
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
        deleteToll(id, name) {

        }
    }
}
</script>

<style>

</style>