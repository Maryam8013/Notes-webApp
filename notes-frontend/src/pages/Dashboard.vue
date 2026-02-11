<template>
  <div class="p-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between mb-2">
        <div>
          <h2 class="text-4xl font-bold text-slate-800 mb-2">Your Notes</h2>
          <p class="text-slate-500">Capture your thoughts and ideas</p>
        </div>
        <button
          @click="goToCreateNote"
          class="group flex items-center space-x-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 transition-all duration-200 hover:scale-105"
        >
          <svg
            class="w-5 h-5 transition-transform group-hover:rotate-90"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 4v16m8-8H4"
            />
          </svg>
          <span class="font-semibold">Add Note</span>
        </button>
      </div>
    </div>

    <!-- Notes Grid -->
    <div
      v-if="notes.length > 0"
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
    >
      <div
        v-for="note in notes"
        :key="note.id"
        class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:scale-105"
      >
        <div :class="['h-3 bg-gradient-to-r', note.color]"></div>
        <div class="p-6">
          <!-- Card Content (clickable to view) -->
          <div @click="goToViewNote(note.id)" class="cursor-pointer mb-4">
            <h3
              class="text-xl font-bold text-slate-800 mb-3 group-hover:text-indigo-600 transition-colors line-clamp-1"
            >
              {{ note.title }}
            </h3>
            <p class="text-slate-600 text-sm mb-4 line-clamp-3">
              {{ note.content }}
            </p>
          </div>

          <!-- Footer with date and action buttons -->
          <div
            class="flex items-center justify-between pt-4 border-t border-slate-100"
          >
            <span class="text-xs text-slate-400 flex items-center space-x-1">
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

            <!-- Action Buttons -->
            <div class="flex items-center space-x-2">
              <!-- Edit Button -->
              <button
                @click.stop="goToEditNote(note.id)"
                class="p-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition-all duration-200 hover:scale-110"
                title="Edit note"
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
              </button>

              <!-- Delete Button -->
              <button
                @click.stop="confirmDelete(note)"
                class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-all duration-200 hover:scale-110"
                title="Delete note"
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
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="flex flex-col items-center justify-center py-20">
      <div
        class="w-32 h-32 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mb-6"
      >
        <svg
          class="w-16 h-16 text-indigo-400"
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
      <h3 class="text-2xl font-bold text-slate-800 mb-2">No notes yet</h3>
      <p class="text-slate-500 mb-6">
        Start creating your first note to get organized
      </p>
      <button
        @click="goToCreateNote"
        class="flex items-center space-x-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 transition-all duration-200"
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
            d="M12 4v16m8-8H4"
          />
        </svg>
        <span class="font-semibold">Create Your First Note</span>
      </button>
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
        <p class="text-slate-600 text-center mb-2">
          Are you sure you want to delete
          <strong>"{{ noteToDelete?.title }}"</strong>?
        </p>
        <p class="text-slate-500 text-sm text-center mb-6">
          This action cannot be undone.
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
import { ref } from "vue";

export default {
  name: "Dashboard",
  // props: {
  //   notes: {
  //     type: Array,
  //     default: () => [],
  //   },
  // },
  props: {
    notes: {
      type: Array,
      default: () => [],
    },
  },
  emits: ["delete-note"],
  setup(props, { emit }) {
    const showDeleteModal = ref(false);
    const noteToDelete = ref(null);

    const confirmDelete = (note) => {
      noteToDelete.value = note;
      showDeleteModal.value = true;
    };

    const handleDelete = () => {
      if (noteToDelete.value) {
        emit("delete-note", noteToDelete.value.id);
        showDeleteModal.value = false;
        noteToDelete.value = null;
      }
    };

    return {
      showDeleteModal,
      noteToDelete,
      confirmDelete,
      handleDelete,
    };
  },
  methods: {
    goToCreateNote() {
      this.$router.push("/create");
    },
    goToEditNote(noteId) {
      this.$router.push(`/edit/${noteId}`);
    },
    goToViewNote(noteId) {
      this.$router.push(`/view/${noteId}`);
    },
  },
};
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
