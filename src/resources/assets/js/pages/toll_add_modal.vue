<script>
import axios from "axios";

export default {
    data(){
        return {
              name: '',
              file: '',
              success: ''
      }
    },
    methods: {
        onFileChange(e){
            console.log(e.target.files[0]);
            this.file = e.target.files[0];
        },
        formSubmit(e) {
            e.preventDefault();
            let currentObj = this;
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            let formData = new FormData();
            formData.append('file', this.file);
            $("#send").attr("disabled", true);
            $(".close").attr("disabled", true);
            axios.post('/api/lib/toll/import', formData, config)
              .then(function (response) {
                  currentObj.success = response.data.message;
                  if(response.data.success == true){
                      window.location.reload();
                  };
              })
              .catch(function (error) {
                  currentObj.output = error;
              });

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
              <h5 class="modal-title">{{ trans('toll.toll_import') }}</h5>
              <button type="button" class="close" data-dismiss="modal" @click="$emit('close')" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <div class="modal-body">
            <slot name="body">
                <div class="card-body">
                  <div v-if="success != ''" class="alert alert-success" role="dark">
                      {{ trans('toll.'+success+'') }}
                  </div>
                  <form @submit="formSubmit" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="">Envie um arquivo</label>
                      <input type="file" id="file" class="form-control" v-on:change="onFileChange">
                    </div>
                  </form>
              </div>
            </slot>
          </div>
          <div class="modal-footer">
            <button id="send" class="btn btn-success">{{ trans('toll.send') }}</button>
          </div>
        </div>
      </div>
    </div>
  </transition>

</template>
<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
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
  width: 420px;
  margin: 0px auto;
  padding: 10px 15px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
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

.btn-file{
  background-color: DodgerBlue; /* Blue background *
  color: white; /* White text */
  padding: 12px 16px; /* Some padding */
  font-size: 16px; /* Set a font size */
  cursor: pointer; /* Mouse pointer on hover */
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}
</style>