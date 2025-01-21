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

                if (response.ok) {
                    const data = await response.json();

                    // Simples verificação de token ou sucesso
                    if (data.token) {
                        console.log("Login bem-sucedido:", data);

                        // Redirecionar para o Dashboard
                        this.$router.push("/dashboard");
                    } else {
                        console.error("Falha no login:", data.message || "Erro desconhecido");
                        alert(data.message || "Erro ao logar.");
                    }
                } else {
                    const errorData = await response.json();
                    console.error("Erro na resposta:", errorData);
                    alert(errorData.message || "Erro ao logar.");
                }
            } catch (error) {
                console.error("Erro de requisição:", error);
                alert("Erro ao tentar realizar o login. Verifique sua conexão.");
            }
        },
    },
};
</script>