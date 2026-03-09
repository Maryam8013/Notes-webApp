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
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-4xl font-bold text-slate-800 mb-2">Edit Note</h2>
          <p class="text-slate-500">Make changes to your note</p>
        </div>
        <button
          @click="confirmDelete"
          class="flex items-center space-x-2 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-red-200 hover:shadow-xl hover:shadow-red-300 transition-all duration-200 hover:scale-105 font-semibold"
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
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
            />
          </svg>
          <span>Delete Note</span>
        </button>
      </div>
    </div>

    <!-- Form -->
    <div v-if="editedNote" class="max-w-3xl">
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <form @submit.prevent="handleSubmit">
          <!-- Title Input -->
          <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">
              Title
            </label>
            <input
              v-model="editedNote.title"
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
              v-model="editedNote.content"
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
              Save Changes
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

      <!-- Note Info -->
      <div
        class="mt-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6"
      >
        <!-- <div class="flex items-center space-x-2 text-sm text-indigo-700">
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
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
            />
          </svg>
          <span class="font-semibold">Created on {{ editedNote.date }}</span>
        </div> -->
      </div>
    </div>

    <!-- Note not found -->
    <div v-else class="max-w-3xl">
      <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
        <p class="text-slate-600">Note not found</p>
        <button
          @click="$router.push('/')"
          class="mt-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl"
        >
          Back to Dashboard
        </button>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      v-if="showDeleteModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
      @click.self="showDeleteModal = false"
    >
      <div
        class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all"
      >
        <div
          class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4"
        >
          <svg
            class="w-8 h-8 text-red-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
            />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 text-center mb-2">
          Delete Note?
        </h3>
        <p class="text-slate-600 text-center mb-6">
          Are you sure you want to delete this note? This action cannot be
          undone.
        </p>
        <div class="flex space-x-3">
          <button
            @click="handleDelete"
            class="flex-1 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-red-600 transition-all duration-200 font-semibold"
          >
            Delete
          </button>
          <button
            @click="showDeleteModal = false"
            class="flex-1 bg-slate-100 text-slate-700 px-6 py-3 rounded-xl hover:bg-slate-200 transition-all duration-200 font-semibold"
          >
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, inject } from "vue";
import { useRoute, useRouter } from "vue-router";

export default {
  name: "EditNote",
  emits: ["edit-note", "delete-note"],
  setup(props, { emit }) {
    const route = useRoute();
    const router = useRouter();
    const notes = inject("notes");
    const showDeleteModal = ref(false);

    const noteId = parseInt(route.params.id);
    const originalNote = computed(() =>
      notes.value.find((n) => n.id === noteId),
    );
    const editedNote = ref(
      originalNote.value ? { ...originalNote.value } : null,
    );

    const handleSubmit = () => {
      if (editedNote.value?.title.trim() && editedNote.value?.content.trim()) {
        console.log("Submitting edit:", editedNote.value); // DEBUG
        emit("edit-note", editedNote.value);
        router.push("/");
      }
    };

    const confirmDelete = () => {
      showDeleteModal.value = true;
    };

    const handleDelete = () => {
      if (editedNote.value) {
        emit("delete-note", editedNote.value.id);
        showDeleteModal.value = false;
        router.push("/");
      }
    };

    return {
      editedNote,
      showDeleteModal,
      handleSubmit,
      confirmDelete,
      handleDelete,
    };
  },
};
</script>
