<template>
    <div class="col-md-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">{{ trans('toll.toll_settings') }}</h4>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="usr"> {{ trans('toll.activate') }} </label>
                        <select v-model="is_toll_active" class="form-control">
                            <option value="1">{{ trans('toll.yes')  }}</option>
                            <option value="0">{{ trans('toll.no')  }}</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="usr"> {{ trans('toll.estimate_apply') }} </label>
                        <select v-model="apply_toll_in_estimate" class="form-control">
                            <option value="1">{{ trans('toll.yes')  }}</option>
                            <option value="0">{{ trans('toll.no')  }}</option>
                        </select>
                    </div>
                </div>
                
            </div>

            <div class="form-group text-right button-save mr-4">
                <button type="button" class="btn btn-success" @click="saveSetting">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
                    {{ trans('toll.save') }}
                    </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: [
        'istollactive',
        'applytollinestimate'
    ],
    data() {
        return {
            is_toll_active: 0,
            apply_toll_in_estimate: 0,
        }
    },
    methods: {
        async saveSetting() {
            try {
                const { data: response } = await axios.post('/api/lib/toll/save_setting', {
                    is_toll_active: this.is_toll_active,
                    apply_toll_in_estimate: this.apply_toll_in_estimate
                });

                if (response.success) {
                    this.$swal({
                        type: 'success',
                        title: 'OK!'
                    });
                } else {
                    this.$swal({
                        type: 'error'
                    });
                }
            } catch (error) {
                console.log('saveSetting', error);
                this.$swal({
                    type: 'error'
                });
            }
        }
    },
    created() {
        this.is_toll_active = this.istollactive;
        this.apply_toll_in_estimate = this.applytollinestimate;
    }
}
</script>

<style>

</style>