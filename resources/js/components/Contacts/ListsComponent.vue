<template>
    <div >
        <ul class="navbar-nav mt-1 ">
            <li class="nav-item">
                <router-link to="/form" class="nav-link active text-white ml-5" aria-current="page" href="#"><i class="bi bi-person-add text-warning" style="margin-left: 30px;font-size: 1.5rem;"></i> </router-link>
            </li>
        </ul>
        <div class="d-flex col-xs-4 col-md-12 col-lg-12 mt-3 p-3" role="search">
            <input  v-on:keydown="onChangeSearch"   class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search" name="search" v-model="search">
        </div>
        <ul class="nav flex-column sticky-top pl-0 pt-0 mt-0" v-for="contact in contacts" :key="contact.id">
            <li class="nav-item ">
                <router-link  :to="'/form/'+contact.id" class="nav-link active" aria-current="page" >
                    <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1 text-info">{{contact.name}} {{contact.lastname}}</strong>
                        <small class="text-info">{{contact.edad }} años</small>
                    </div>
                    <div class="col-10 mb-1 small">
                        <small class="text-light">{{contact.email}}</small>
                    </div>
                    <div class="col-10 mb-1 small">
                        <small class="text-light">{{contact.phone}}</small>
                    </div>
                </router-link>
            </li>
            <hr class="text-white">
        </ul>
        <infinite-loading  @infinite="infiniteHandler"></infinite-loading>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                contacts:[],
                page:0,
                search:''
            }
        },
        created(){
           // this.getContacts();
        },
        methods:{
            getContacts($state){

                this.page++;
                let url = 'http://127.0.0.1:8000/users?page='+this.page;
                axios.get(url)
                .then(response=>{
                    let contacts = response.data.data;
                    if(contacts.length){
                        this.contacts = this.contacts.concat(contacts);
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                })
                .catch(err=>console.log(err))
            },
            getContactsFilter(param){
                this.page++;
                this.contacts=[];
                param = param ? param:'getall'
                let url = 'http://127.0.0.1:8000/users/'+param+'/search/?page='+this.page;
                axios.get(url)
                .then(response=>{
                    let contacts = response.data.data;
                    if(contacts.length){
                        this.contacts = this.contacts.concat(contacts);
                        $state.loaded();
                    }else{
                        $state.complete();
                    }
                })
                .catch(err=>console.log(err))
            },
            infiniteHandler($state){
                this.getContacts($state)
            },
            onChangeSearch(e){
                this.page=0;
                this.contacts = [];
                this.getContactsFilter(e.target.value);

            }

        },
        
    }
</script>
