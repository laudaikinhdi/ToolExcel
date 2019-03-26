<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    
    <div class="container" id="app">
        <template v-if="screen.screenForm">
            <div class="jumbotron">
                <h1 class="display-3 text-center">Vue.js</h1>
                <p class="lead text-center">(Methods, Computed, Watcher)</p>
                <hr class="my-2">
                <div class="">
                    <form>
                        <div class="col-md-12">
                            <div class="form-group col-md-4">
                                <label>Họ và tên: @{{form.name}}</label>
                                <input class="form-control" v-model.trim="form.name" placeholder="Họ và tên" >
                            </div>
                            <div class="form-group col-md-4">
                                <span class="text-danger" v-if="errors.name != ''">@{{errors.name}}</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-4">
                                <label>Email: @{{form.email}}</label>
                                <input class="form-control" v-model.trim="form.email" placeholder="Email" >
                            </div>
                            <div class="form-group col-md-4">
                                <span class="text-danger" v-if="errors.email != ''">@{{errors.email}}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Birthday: @{{form.birthday}}</label>
                                <input type="date" v-model.trim="form.birthday" class="form-control" placeholder="Date">
                            </div>
                            <div class="form-group col-md-4">
                                <button class="btn btn-primary" @click.prevent="go">Xác nhận</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </template>
        <template v-if="screen.screenData">
            <div class="col-md-12 " style="margin-top:200px;">
                <button class="btn btn-success" @click="goBack">&laquo;   Back</button>
                <div class="col-md-5 offset-md-4 form-group">
                    <input v-model.trim="search" placeholder="Search..." class="form-control">
                </div>
                <div class="col-md-12">
                    <ul class="list-group" v-for="(value, index) in computedSearch" :key="'data_' + index" style="width: 25%;float: left;">
                        <li class="list-group-item">@{{value.name}} - @{{value.email}} - @{{value.birthday | formatDate}}</li>
                    </ul>
                </div>
            </div>
        </template>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script>
        new Vue({
            el: "#app",
            data:{
                form:{
                    name:'',
                    email:'',
                    birthday:''
                },
                screen:{
                    screenForm: true,
                    screenData: false,
                },
                dataList:[
                    { name: 'Tân', email: 'tanmnt@onetech.vn',birthday:'1996/02/17'},
                    { name: 'Duy', email: 'duy@onetech.vn',birthday:'1995/02/1/08'},
                    { name: 'Huy', email: 'huy@onetech.vn',birthday:'1997/02/19'},
                    { name: 'Bảo', email: 'bao@onetech.vn',birthday:'1998/02/07'},
                    { name: 'Hùng', email: 'hung@onetech.vn',birthday:'1999/02/27'},
                    { name: 'Tâm', email: 'tam@onetech.vn',birthday:'2000/02/17'},
                ],
                search:'',
                errors:{
                    name: '',
                    email:''
                }
            },
            watch:{
                'form.name'(valNew, vald){
                    if(valNew.length == 0){
                        this.errors.name = 'Họ và tên không được để trống';
                    }else{
                        this.errors.name = '';
                    }
                },
                'form.email'(val){
                    var check = this.checkEmail(val);
                    if(!check){
                        this.errors.email = 'Email không hợp lệ';
                    }else{
                        this.errors.email = '';
                    }
                }
            },
            methods:{
                checkEmail(value){
                    var rex = /^[a-z]+@onetech.vn$/;
                    return rex.test(value);
                },
                go(){
                    if(this.form.email != '' && this.form.name != '' && this.form.birthday !=''){
                        this.dataList.push({name: this.form.name, email: this.form.email, birthday: this.form.birthday})
                    }
                    this.screen.screenForm = false;
                    this.screen.screenData = true;
                },
                goBack(){
                    this.screen.screenForm = true;
                    this.screen.screenData = false;
                    
                }
            },
            computed:{
                computedSearch(){
                    console.log(1);
                    return this.dataList.filter((data)=>{
                        return  data.email.includes(this.search); 
                    });
                }
            },
            filters:{
                formatDate(value){
                    console.log(1);
                    return moment(new Date(value)).format('DD-MM-YYYY');
                }
            }
        });
    </script>
</body>
</html>