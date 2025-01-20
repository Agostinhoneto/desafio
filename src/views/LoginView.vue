<template>
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>Admin</b>LTE</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <form @submit.prevent="handleLogin">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" v-model="email" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" v-model="password"
                                required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" v-model="remember" />
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Sign In
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <p class="mb-1">
                        <a href="#">I forgot my password</a>
                    </p>
                    <p class="mb-0">
                        <a href="#" class="text-center">Register a new membership</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
    </div>
</template>
<script>
export default {
    name: "LoginView",
    data() {
        return {
            email: "",
            password: "",
            remember: false,
        };
    },
    methods: {
        async handleLogin() {
            try {
                const response = await fetch("http://127.0.0.1:8000/api/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        email: this.email,
                        password: this.password,
                        remember: this.remember,
                    }),
                });
                const data = await response.json();
                console.log(data);
            } catch (error) {
                console.error("Error:", error);
            }
        },
    },
};
</script>

<style scoped>
.hold-transition.login-page {
    height: 100vh;
    background: #f4f6f9;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>