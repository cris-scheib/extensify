import Router from "vue-router";
import Vue from "vue";

Vue.use(Router);

let router = new Router({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "home",
      component: require("@/components/pages/Home").default,
      meta: {
        auth: false,
      },
    },
    {
      path: "/dashboard",
      name: "dashboard",
      component: require("@/components/pages/Dashboard").default,
      meta: {
        auth: true,
      },
    },
    {
      path: "/favorite-artists",
      name: "favorite-artists",
      component: require("@/components/pages/FavoriteArtists").default,
      meta: {
        auth: true,
      },
    },
    {
      path: "/followed-artists",
      name: "followed-artists",
      component: require("@/components/pages/FollowedArtists").default,
      meta: {
        auth: true,
      },
    },
    {
      path: "/recommendations",
      name: "recommendations",
      component: require("@/components/pages/Recommendations").default,
      meta: {
        auth: true,
      },
    },
    {
      path: "/favorite-tracks",
      name: "favorite-tracks",
      component: require("@/components/pages/FavoriteTracks").default,
      meta: {
        auth: true,
      },
    },
    {
      path: "/history",
      name: "history",
      component: require("@/components/pages/History").default,
      meta: {
        auth: true,
      },
    },
    {
      path: "/login",
      name: "login",
      component: require("@/components/pages/Login").default,
      meta: {
        auth: false,
      },
    },
    {
      path: "/unauthorized",
      name: "unauthorized",
      component: require("@/components/pages/Unauthorized").default,
      meta: {
        auth: false,
      },
    },
    {
      path: "/settings",
      name: "settings",
      component: require("@/components/pages/Settings").default,
      meta: {
        auth: true,
      },
    },
    {
      path: "/logout",
      name: "logout",
      component: require("@/components/pages/Logout").default,
      meta: {
        auth: true,
      },
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.auth)) {
    const user = localStorage.getItem("user");

    if (!user || user === null)
      next({ path: "/", params: { nextUrl: to.fullPath } });
    else next();
  } else {
    next();
  }
});

export default router;
