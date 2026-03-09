<template>
  <div
    class="flex h-screen bg-gradient-to-br from-slate-50 to-slate-100 overflow-hidden"
  >
    <!-- Mobile Hamburger Button -->
    <button
      @click="sidebarOpen = true"
      class="lg:hidden fixed top-4 left-4 z-40 p-3 bg-white rounded-xl shadow-lg text-slate-700 hover:bg-slate-50 transition-all"
    >
      <svg
        class="w-6 h-6"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"
        />
      </svg>
    </button>

    <!-- Overlay for mobile -->
    <div
      v-if="sidebarOpen"
      @click="sidebarOpen = false"
      class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity"
    ></div>

    <!-- Sidebar -->
    <aside
      :class="[
        'fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white shadow-xl border-r border-slate-200 transform transition-transform duration-300 ease-in-out',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
      ]"
    >
      <div class="flex flex-col h-full">
        <div class="p-6">
          <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-3">
              <div
                class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center"
              >
                <svg
                  class="w-6 h-6 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                  />
                </svg>
              </div>
              <h1
                class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"
              >
                NotesApp
              </h1>
            </div>
            <button
              @click="sidebarOpen = false"
              class="lg:hidden p-2 text-slate-400 hover:text-slate-600 transition-colors"
            >
              <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <nav class="space-y-2">
            <button @click="navigateTo('/')" :class="navButtonClass('/')">
              <span class="font-medium">Dashboard</span>
            </button>

            <button
              @click="navigateTo('/create')"
              :class="navButtonClass('/create')"
            >
              <span class="font-medium">Create Note</span>
            </button>
          </nav>
        </div>

        <div class="mt-auto p-6 border-t border-slate-200">
          <div
            class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4"
          >
            <p class="text-sm text-slate-600 mb-1">Total Notes</p>
            <p class="text-2xl font-bold text-indigo-600">{{ notes.length }}</p>
          </div>
          <button
            @click="logout"
            class="mt-4 w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 transition-all duration-200 font-semibold"
          >
            Logout
          </button>
        </div>
      </div>
    </aside>

    <main class="flex-1 overflow-auto pt-16 lg:pt-0">
      <router-view
        :notes="notes"
        :loading="loading"
        @add-note="addNote"
        @edit-note="editNote"
        @delete-note="deleteNote"
      />
    </main>
  </div>
</template>

<script>
import { ref, provide, onMounted, watch } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import { API_BASE_URL } from "../config/api";

export default {
  name: "App",
  setup() {
    const router = useRouter();
    const route = useRoute();
    const sidebarOpen = ref(false);
    const notes = ref([]);
    const loading = ref(false);
    const API = API_BASE_URL;

    // Fetch all notes from backend
    const fetchNotes = async () => {
      loading.value = true;
      try {
        const res = await axios.get(`${API}/notes`);
        notes.value = res.data;
      } catch (err) {
        console.error("API Error:", err);
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => fetchNotes());

    // Close sidebar on route change
    watch(route, () => {
      sidebarOpen.value = false;
    });

    provide("notes", notes);

    const navigateTo = (path) => {
      router.push(path);
    };

    const logout = async () => {
      try {
        await axios.post(`${API}/logout`);
      } catch (err) {
        console.error("Logout Error:", err);
      } finally {
        localStorage.removeItem("token");
        delete axios.defaults.headers.common.Authorization;
        notes.value = [];
        router.push("/login");
      }
    };

    // CRUD Operations
    const addNote = async (note) => {
      try {
        const payload = {
          ...note,
          title: note.title.trim(),
          content: note.content.trim(),
        };
        const res = await axios.post(`${API}/notes`, payload);
        notes.value.push(res.data);
        router.push("/");
      } catch (err) {
        console.error("Add Note Error:", err);
      }
    };

    const editNote = async (updatedNote) => {
      console.log("Editing note:", updatedNote); // DEBUG
      try {
        const res = await axios.put(
          `${API}/notes/${updatedNote.id}`,
          updatedNote,
        );
        const index = notes.value.findIndex((n) => n.id === updatedNote.id);
        if (index !== -1) {
          notes.value[index] = res.data;
        }
      } catch (err) {
        console.error("Edit Note Error:", err);
      }
    };

    const deleteNote = async (id) => {
      try {
        await axios.delete(`${API}/notes/${id}`);
        notes.value = notes.value.filter((n) => n.id !== id);
        router.push("/");
      } catch (err) {
        console.error("Delete Note Error:", err);
      }
    };

    const navButtonClass = (path) => {
      return [
        "w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200",
        route.path === path
          ? "bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-200"
          : "text-slate-600 hover:bg-slate-100",
      ];
    };

    return {
      sidebarOpen,
      notes,
      loading,
      navigateTo,
      addNote,
      editNote,
      deleteNote,
      navButtonClass,
      logout,
    };
  },
};
</script>
