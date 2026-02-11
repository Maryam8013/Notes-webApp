import { createRouter, createWebHashHistory } from "vue-router";
import Dashboard from "./pages/Dashboard.vue";
import CreateNote from "./pages/CreateNote.vue";
import EditNote from "./pages/EditNote.vue";
import ViewNote from "./pages/ViewNote.vue";
import Login from "./pages/Login.vue";
import Signup from "./pages/Signup.vue";
import MainLayout from "./layouts/MainLayout.vue";
import AuthLayout from "./layouts/AuthLayout.vue";

const routes = [
  {
    path: "/",
    component: MainLayout,
    meta: { requiresAuth: true },
    children: [
      { path: "", name: "Dashboard", component: Dashboard },
      { path: "create", name: "CreateNote", component: CreateNote },
      { path: "edit/:id", name: "EditNote", component: EditNote },
      { path: "view/:id", name: "ViewNote", component: ViewNote },
    ],
  },
  {
    path: "/",
    component: AuthLayout,
    children: [
      { path: "login", name: "Login", component: Login },
      { path: "signup", name: "Signup", component: Signup },
    ],
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

// Route Guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("token");

  if (to.matched.some((record) => record.meta.requiresAuth) && !token) {
    next("/login");
  } else if ((to.name === "Login" || to.name === "Signup") && token) {
    next("/");
  } else {
    next();
  }
});

export default router;
