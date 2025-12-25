const Loader = {
    show: function (element) {
        element.classList.add("ajax-container", "is-loading");
    },
    hide: function (element) {
        element.classList.remove("ajax-container", "is-loading");
    },
};
