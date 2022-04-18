<template>
    <div>
        <h1 class="text-center">Users Lists</h1>
        <button type="button" class="btn btn-success mb-3 ms-auto d-block" @click="openModal">Create</button>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="index">
                    <th scope="row">{{ index+1 }}</th>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone }}</td>
                    <td>
                        <a href="#" @click.prevent="getUserData(user.id)" class="btn btn-info me-2">Edit</a>
                        <a href="#" @click.prevent="deleteUser(user.id)" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Modal -->
        <div class="modal fade" ref="exampleModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 p-3">
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" v-model="user.name" class="form-control" id="name">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" v-model="user.email" class="form-control" id="email">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" v-model="user.phone" class="form-control" id="phone">
                            </div>
                        </div>
                        <button v-if="!user.id" type="submit" @click.prevent="sumbit" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Save</button>
                        <button v-if="user.id" type="submit" @click.prevent="updateUser(user.id)" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Update</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Modal } from "bootstrap";
import axios from "axios";
import { IsUser } from '../../types/user';

@Component({
  name: 'ExampleComponent',
})
export default class extends Vue {
    public users: IsUser[] = [];
    public user: IsUser = {
        name: "",
        email: "",
        phone: 0
    };
    public modal: any;

    created(){
        this.getUsers();
    }

    private async getUsers(){
        await axios.get('/api/users').then(({ data }) => {
            this.users = data.users.data;
        }).catch(error => {
            console.log(error.message);
        })
    }

    public openModal(){
        this.user = {
            name: "",
            email: "",
            phone: 0
        };

        this.modal = new Modal(document.getElementById('exampleModal')!, {
            keyboard: false
        });
        this.modal.show();
    }

    private sumbit(){
        axios.post('api/user', this.user).then(response => {
            console.log(response.data.message);
            this.getUsers();
            this.user = {
                name: "",
                email: "",
                phone: 0
            };
        }).catch(error => {
            console.log(error.message);
        })
    }
    // get a  user by id for update
    public getUserData(id: number){
        this.modal.show();
        axios.get('/api/user/' + id).then(({ data}) => {
            this.user = data.user;
        })
    }
    private updateUser(id: number){
        axios.post('/api/user/' +id, this.user).then(response => {
            console.log(response.data.message);
            this.getUsers();
        }).catch(error => {
            console.log(error.message);
        })
    }
    private deleteUser(id: number){
        axios.get('/api/user/delete/' +id).then(response => {
            console.log(response.data.message);
            this.getUsers();
        }).catch(error => {
            console.log(error.message);
        })
    }
}

</script>
