document.addEventListener("DOMContentLoaded", () => {
    const selectAll = document.getElementById("selectAll");
    if (selectAll) {
        selectAll.addEventListener("change", function () {
            const checkboxes = document.querySelectorAll('input[name="ids[]"]');
            checkboxes.forEach((cb) => (cb.checked = this.checked));
        });
    }
});
