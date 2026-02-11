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
        Sign Up
      </h2>
      <form @submit.prevent="signup">
        <div class="mb-4">
          <label class="block text-sm font-semibold text-slate-700 mb-2"
            >Name</label
          >
          <input
            v-model="name"
            type="text"
            required
            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition-all"
          />
        </div>
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
          :disabled="loading"
          type="submit"
          class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold"
        >
          {{ loading ? "Signing Up..." : "Sign Up" }}
        </button>
      </form>
      <p class="mt-4 text-sm text-slate-500 text-center">
        Already have an account?
        <router-link
          to="/login"
          class="text-indigo-600 hover:text-indigo-700 font-semibold"
          >Login</router-link
        >
      </p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
  setup() {
    const router = useRouter();
    const name = ref("");
    const email = ref("");
    const password = ref("");
    const loading = ref(false);

    const signup = async () => {
      loading.value = true;
      try {
        const res = await axios.post("http://127.0.0.1:8000/api/signup", {
          name: name.value,
          email: email.value,
          password: password.value,
        });
        localStorage.setItem("token", res.data.token);
        axios.defaults.headers.common["Authorization"] =
          `Bearer ${res.data.token}`;
        router.push("/"); // redirect to dashboard
      } catch (err) {
        if (err.response && err.response.status === 422) {
          const messages = Object.values(err.response.data).flat().join("\n");
          alert(messages);
        } else {
          alert(err.response?.data?.message || "Signup failed");
        }
        console.error(err);
      } finally {
        loading.value = false;
      }
    };

    return { name, email, password, signup, loading };
  },
};
</script>
