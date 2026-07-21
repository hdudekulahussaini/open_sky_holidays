document.addEventListener("DOMContentLoaded", function () {

    const imageInputs = document.querySelectorAll(".image-preview-input");

    imageInputs.forEach(function (input) {

        input.addEventListener("change", function () {

            const preview = document.querySelector(this.dataset.preview);

            if (!preview) return;

            const file = this.files[0];

            if (!file) {
                preview.src = "";
                preview.classList.remove("show");
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.add("show");
            };

            reader.readAsDataURL(file);

        });

    });

});