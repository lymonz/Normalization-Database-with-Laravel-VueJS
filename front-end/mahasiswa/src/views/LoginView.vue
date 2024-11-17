<template lang="">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body">
        <ul class="nav nav-tabs mb-4" id="authTab" role="tablist">
            <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">
                Login
            </button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">
                Register
            </button>
            </li>
        </ul>

        <div class="tab-content" id="authTabContent">
            <!-- Login Form -->
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
            <h2 class="text-center login-text">Login • <span class="text-dark fw-bold">Penilaian</span><span class="text-info fw-bold">Mahasiswa</span></h2>
            <div class="d-flex justify-content-center mb-4">
                
            </div>
            <form @submit.prevent>
                <div class="mb-3">
                <label for="loginEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="loginEmail" placeholder="Enter your email" v-model="email" required>
                </div>
                <div class="mb-3">
                <label for="loginPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="loginPassword" placeholder="Enter your password" v-model="password" required>
                </div>
                <div class="d-grid">
                <button @click="login()" class="btn btn-primary">Login</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none">Forgot password?</a>
            </div>
            </div>

            <!-- Register Form -->
            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
            <h2 class="text-center text-dark mb-4">Register</h2>
            <form id="registerForm" @submit.prevent>
                <div class="mb-3">
                <label for="registerName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="registerName" placeholder="Enter your full name" v-model="name" required>
                </div>
                <div class="mb-3">
                <label for="registerEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="registerEmail" placeholder="Enter your email" v-model="email" required>
                </div>
                <div class="mb-3">
                <label for="registerPassword" class="form-label">Password</label>
                <input type="password" class="form-control" v-model="password" id="registerPassword" placeholder="Enter your password" required>
                </div>
                <div class="d-grid">
                <button @click="register()" class="btn btn-success">Register</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</div>

</template>
<script>
import axios from 'axios';
import router from '@/router';
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            email:"",
            password:"",
        }
    },

    mounted() {
        
    },
    methods: {
        login(){
            axios.post('http://localhost:8000/api/auth/login', {
                email: this.email,
                password: this.password
            })
            .then(function (response) {
                localStorage.setItem('token', response.data.access_token);
                localStorage.setItem('email', response.data.user.email);
                localStorage.setItem('name', response.data.user.name);
                Swal.fire({
                    title: 'Success!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000
                }).then(() => {
                    router.push({name:'home'});
                })
            })
            .catch(function (error) {
                Swal.fire({
                    title: 'Invalid Data!',
                    text: error.response.data.message,
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000
                });
            });
        },
        register(){
            axios.post('http://localhost:8000/api/auth/register', {
                name: this.name,
                email: this.email,
                password: this.password
            })
            .then(function (response) {
                Swal.fire({
                    title: 'Success Registered Account!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000
                }).then(() => {
                    window.location.reload();
                })
            })
            .catch((error) => {
                let errorMessage = 'Failed to register account!';

                if (error.response && error.response.data) {
                    if (typeof error.response.data === 'object') {
                        
                        errorMessage = Object.values(error.response.data)
                            .flat()
                            .join('');
                    } else if (typeof error.response.data.message === 'string') {
                        errorMessage = error.response.data.message;
                    }
                }

                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 3000,
                    customClass: {
                        htmlContainer: 'swal-html-container'  // Menambahkan custom class
                    }
                });
            });
        }
    },
    mounted(){
        if(localStorage.getItem('token')) {
            router.push({name:'home'});
        }
    }
};
</script>
<style scoped>

.login-text{
    font-size: 28px;
    font-weight: 800;
    color: #000;
    font-family: "K2D", sans-serif;
}

</style>
