const sidebar = document.getElementById("sidebar");
const button = document.getElementById("buttonSidebar");
const content = document.getElementById("contentSection");
const icon = document.getElementById("iconBtn");

let isOpen = true;

button.addEventListener("click", () => {

    if (isOpen) {
        sidebar.classList.replace("left-0", "-left-64");

        content.classList.remove("lg:ml-64", "lg:w-[calc(100%-16rem)]");
        content.classList.add("ml-0", "w-full");

        button.classList.add('-right-15')
        button.classList.remove('-right-5')

        icon.classList.remove('rotate-180')

    } else {
        sidebar.classList.replace("-left-64", "left-0");

        content.classList.remove("ml-0", "w-full");
        content.classList.add("lg:ml-64", "lg:w-[calc(100%-16rem)]");
        button.classList.remove('-right-15')
        button.classList.add('-right-5')

        icon.classList.add('rotate-180')
    }

    isOpen = !isOpen;
});