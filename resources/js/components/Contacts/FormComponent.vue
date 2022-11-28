<template>
    <div class="container mt-5" >
        <div class="row ">
            <div class="col-md-12 ">
                <div class="card bg-dark d-flex" style="align-items:center; " >
                    <div class="card-header text-white row" style="width:100%">

                        <div class="col-md-10">
                            {{this.id ? 'Editar Contacto' : 'Crear Contacto'}}
                        </div>

                            <div class="col-md-2 text-center" v-if="showButtons.showbtnEditar" >
                                <a href="#"  data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-trash text-danger m-3" ></i></a>
                                <a href="#" v-on:click="enableEdit()"><i class="bi bi-pencil text-info"></i></a>
                            </div>

                    </div>
                    <div class="card-body">
                        <form v-on:submit.prevent="saveContact()">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label text-white text-white">Nombre</label>
                                <input type="text" class="form-control" id="name" v-model="contact.name" :disabled="disableInputBool" placeholder="Nombre">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label text-white">Apellido</label>
                                <input type="text" class="form-control" id="lastname" v-model="contact.lastname" :disabled="disableInputBool" placeholder="Apellido">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label text-white">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="birthday" v-model="contact.birthday" :disabled="disableInputBool" placeholder="Fecha de nacimiento">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label text-white">Dirección</label>
                                <input type="text" class="form-control" id="address" v-model="contact.address" :disabled="disableInputBool" placeholder="Dirección">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label text-white">Email</label>
                                <input type="email" class="form-control" id="email" aria-describedby="email" v-model="contact.email" :disabled="disableInputBool" placeholder="Email">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label text-white">Teléfono</label>
                                <input type="text" class="form-control" id="phone" v-model="contact.phone" :disabled="disableInputBool" placeholder="Teléfono">
                            </div>
                            <div v-if="showButtons.showbtnSave" class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-block">{{ this.id ? 'Actualizar' : 'Crear'}}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
        <modal-component title="Eliminar Contacto" msg="Esta a punto de elimnar un contacto. Desea continuar?" v-on:getFunction="destroyContact" tagBtn="Si, continuar"/>



    </div>
</template>

<script>
    export default {
        data(){
            return{
                showButtons:{
                    showbtnSave:false,
                    showbtnEditar:false,
                },
                disableInputBool: false,
                id:this.$route.params.id,
                contact:{
                    id:'',
                    name:'',
                    lastname:'',
                    birthday:'',
                    address:'',
                    email:'',
                    phone:'',
                },
            }
        },

        created(){
            this.iniData();

        },


        methods:{
            iniData(){
                if(this.id){
                    this.disableInputBool = true;
                    this.showButtons.showbtnSave = false;
                    this.showButtons.showbtnEditar = true;
                    axios.get('users/'+this.id+'/edit')
                    .then(response=>{
                        this.contact = response.data;
                    })
                    .catch(err=>{console.log(err)});
                }else{ console.log('entro a segundo')
                    this.showButtons.showbtnSave = true;
                    this.showButtons.showbtnEditar = false;
                }
            },
            saveContact(){

                if(!this.id){
                    axios.post('/users',this.contact).then(response=>{
                        this.$swal('Creado correctamente')
                    }).catch(err=>{
                        console.log(err)
                    })
                    this.clearForm();

                    this.$router.push('/')
                }else{
                    axios.put('/users/'+this.id,this.contact).then(response=>{
                        this.$swal('Actualizado correctamente')
                    }).catch(err=>{
                        console.log(err)
                    })
                    this.enableEdit();

                    this.$router.push('/');
                }
                location.reload()
            },
            destroyContact(){
                axios.delete('users/'+this.id)
                .then(response=>this.$swal('Eliminado correctamente'))
                .catch(err=>console.log(err));
                this.$router.push('/');
                location.reload()
            },
            //se ejecuta cunado se da clic en el boton editar para habilitar los input y el boton de actualizar
            enableEdit(){
                this.disableInputBool = !this.disableInputBool;
                this.showButtons.showbtnSave = !this.showButtons.showbtnSave;
            },
            clearForm(){
                this.contact.name = '';
                this.contact.lastname = '';
                this.contact.birthday='';
                this.contact.address='';
                this.contact.email='';
                this.contact.phone='';
            },
            modal(){
                const myModalEl = document.getElementById('exampleModal')
                myModalEl.addEventListener('show.bs.modal', event => {
                // do something...
                })
            }

        },
        watch:{
            '$route.params.id'(newId) {
                if (!newId) {
                    this.id = newId;
                    this.iniData();
                    this.clearForm();
                    this.disableInputBool = false;
                }else if(newId){
                    this.id = newId;
                    this.iniData();

                }
            }
        }
    }
</script>
