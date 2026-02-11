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
      <h2 class="text-4xl font-bold text-slate-800 mb-2">Create New Note</h2>
      <p class="text-slate-500">Add a new note to your collection</p>
    </div>

    <!-- Form -->
    <div class="max-w-3xl">
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <form @submit.prevent="handleSubmit">
          <!-- Title Input -->
          <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Title
            </label>
            <input
              v-model="title"
              type="text"
              placeholder="Enter note title..."
              class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition-all text-slate-800 placeholder-slate-400"
              required
            />
          </div>

          <!-- Content Textarea -->
          <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Content
            </label>
            <textarea
              v-model="content"
              placeholder="Write your note content here..."
              rows="12"
              class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition-all text-slate-800 placeholder-slate-400 resize-none"
              required
            ></textarea>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center space-x-4">
            <button
              type="submit"
              class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 transition-all duration-200 font-semibold hover:scale-105 transform"
            >
              Save Note
            </button>
            <button
              type="button"
              @click="$router.push('/')"
              class="px-6 py-3 rounded-xl border-2 border-slate-200 text-slate-600 hover:bg-slate-50 transition-all duration-200 font-semibold"
            >
              Cancel
            </button>
          </div>
        </form>
      </div>

      <!-- Tips Card -->
      <!-- <div
        class="mt-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6"
      >
        <h3
          class="font-semibold text-indigo-900 mb-2 flex items-center space-x-2"
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
              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <span>Quick Tip</span>
        </h3>
        <p class="text-indigo-700 text-sm">
          Use descriptive titles to easily find your notes later. Your notes are
          automatically saved with the current date.
        </p>
      </div> -->
    </div>
  </div>
</template>

<script>
import { ref } from "vue";

export default {
  name: "CreateNote",
  emits: ["add-note"],
  setup(props, { emit }) {
    const title = ref("");
    const content = ref("");

    const handleSubmit = () => {
      if (!title.value.trim() || !content.value.trim()) return;

      emit("add-note", {
        title: title.value.trim(),
        content: content.value.trim(),
      });

      title.value = "";
      content.value = "";
    };

    return {
      title,
      content,
      handleSubmit,
    };
  },
};
</script>

