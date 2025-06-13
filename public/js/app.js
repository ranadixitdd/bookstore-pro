document.addEventListener("DOMContentLoaded", function () {
    const itemsPerPage = 18;
    const cards = document.querySelectorAll(".product-card");
    const totalPages = Math.ceil(cards.length / itemsPerPage);
    const container = document.querySelector(".pagination");

    function showPage(page) {
        cards.forEach((c, i) => {
            c.style.display =
                i >= (page - 1) * itemsPerPage && i < page * itemsPerPage
                    ? "block"
                    : "none";
        });
    }

    function makeLinks() {
        for (let i = 1; i <= totalPages; i++) {
            const a = document.createElement("a");
            a.href = "#";
            a.innerText = i;
            a.addEventListener("click", (e) => {
                e.preventDefault();
                showPage(i);
                container
                    .querySelectorAll("a")
                    .forEach((x) => x.classList.remove("active"));
                a.classList.add("active");
            });
            container.appendChild(a);
        }
    }

    if (totalPages > 1) {
        makeLinks();
        showPage(1);
        container.querySelector("a").classList.add("active");
    } else {
        cards.forEach((c) => (c.style.display = "block"));
    }
});
