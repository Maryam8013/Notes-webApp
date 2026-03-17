<template>
  <div
    class="flex items-center justify-center h-screen bg-gradient-to-br from-slate-50 to-slate-100"
  >
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md">
      <p class="text-slate-800 text-center text-base font-medium mb-2">
        NotesApp keeps your ideas organized.
      </p>
      <h2
        class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-6 text-center"
      >
        Login
      </h2>
      <form @submit.prevent="login">
        <div class="mb-4">
          <label class="block text-sm font-semibold text-slate-700 mb-2"
            >Email</label
          >
          <input
            v-model="email"
            type="email"
            required
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition-all"
          />
        </div>
        <div class="mb-6">
          <label class="block text-sm font-semibold text-slate-700 mb-2"
            >Password</label
          >
          <input
            v-model="password"
            type="password"
            required
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition-all"
          />
        </div>
        <button
          type="submit"
          class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold"
        >
          Login (Auto Deploy Test)
        </button>
      </form>
      <p class="mt-4 text-sm text-slate-500 text-center">
        Don't have an account?
        <router-link
          to="/signup"
          class="text-indigo-600 hover:text-indigo-700 font-semibold"
          >Sign Up</router-link
        >
      </p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";
import { ref } from "vue";
import { API_BASE_URL } from "../config/api";

export default {
  setup() {
    const router = useRouter();
    const email = ref("");
    const password = ref("");

    const login = async () => {
      try {
        const res = await axios.post(`${API_BASE_URL}/login`, {
          email: email.value,
          password: password.value,
        });
        localStorage.setItem("token", res.data.token);
        router.push("/");
      } catch (err) {
        alert("Invalid credentials");
        console.error(err);
        console.log("test CI");
      }
    };

    return { email, password, login };
  },
};
</script>
