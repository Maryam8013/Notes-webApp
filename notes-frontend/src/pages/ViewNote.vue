<template>
  <div class="p-8">
    <!-- Header -->
    <div class="mb-8">
      <button
        @click="$router.push('/')"
        class="flex items-center space-x-2 text-slate-600 hover:text-indigo-600 transition-colors mb-4 group"
      >
        <svg
          class="w-5 h-5 transition-transform group-hover:-translate-x-1"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M10 19l-7-7m0 0l7-7m-7 7h18"
          />
        </svg>
        <span class="font-medium">Back to Dashboard</span>
      </button>
    </div>

    <!-- Note Content -->
    <div v-if="note" class="max-w-4xl mx-auto">
      <!-- Note Header Card -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
        <div :class="['h-2 bg-gradient-to-r', note.color]"></div>
        <div class="p-8">
          <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
              <h1 class="text-4xl font-bold text-slate-800 mb-3">
                {{ note.title }}
              </h1>
              <div class="flex items-center space-x-4 text-sm text-slate-500">
                <span class="flex items-center space-x-2">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                  </svg>
                  <span>{{ note.date }}</span>
                </span>
                <span class="flex items-center space-x-2">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                    />
                  </svg>
                  <span>{{ note.content.split(" ").length }} words</span>
                </span>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3 ml-4">
              <button
                @click="$router.push(`/edit/${note.id}`)"
                class="flex items-center space-x-2 bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition-all duration-200 shadow-md hover:shadow-lg"
              >
                <svg
                  class="w-4 h-4"
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
                <span class="font-medium">Edit</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Note Body Card -->
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="prose prose-slate max-w-none">
          <div
            class="text-slate-700 text-lg leading-relaxed whitespace-pre-wrap"
          >
            {{ note.content }}
          </div>
        </div>
      </div>

      <!-- Bottom Action Bar -->
      <div class="mt-6 flex items-center justify-between">
        <button
          @click="$router.push('/')"
          class="flex items-center space-x-2 text-slate-600 hover:text-slate-800 transition-colors"
        >
          <svg
            class="w-5 h-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 17l-5-5m0 0l5-5m-5 5h12"
            />
          </svg>
          <span class="font-medium">Back to all notes</span>
        </button>
        <!-- 
        <div class="flex items-center space-x-3">
          <button
            @click="$router.push(`/edit/${note.id}`)"
            class="flex items-center space-x-2 text-indigo-600 hover:text-indigo-700 transition-colors"
          >
            <svg
              class="w-5 h-5"
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
            <span class="font-medium">Edit this note</span>
          </button>
        </div> -->
      </div>
    </div>

    <!-- Note not found -->
    <div v-else class="max-w-3xl mx-auto">
      <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
        <div
          class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4"
        >
          <svg
            class="w-10 h-10 text-slate-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 mb-2">Note not found</h3>
        <p class="text-slate-600 mb-6">
          The note you're looking for doesn't exist or has been deleted.
        </p>
        <button
          @click="$router.push('/')"
          class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold"
        >
          Back to Dashboard
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";
import { API_BASE_URL } from "../config/api";

export default {
  name: "ViewNote",
  setup() {
    const route = useRoute();
    const router = useRouter();
    const noteId = parseInt(route.params.id);
    const note = ref(null);
    const loading = ref(true);

    const fetchNote = async () => {
      try {
        const res = await axios.get(`${API_BASE_URL}/notes/${noteId}`);
        note.value = res.data;
      } catch (err) {
        console.error("Error fetching note:", err);
        note.value = null; // fallback to "Note not found"
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      fetchNote();
    });

    return {
      note,
      loading,
    };
  },
};
</script>

<style scoped>
.prose {
  color: #334155;
}

.whitespace-pre-wrap {
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>
