document.addEventListener("DOMContentLoaded", function() {
    const deleteLinks = document.querySelectorAll(".delete-link");

    deleteLinks.forEach(link => {
        link.addEventListener("click", function(event) {
            if (!confirm("Are you sure you want to delete this?")) {
                event.preventDefault();
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-link").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Mencegah navigasi langsung

            if (confirm("Are you sure you want to delete this content?")) {
                window.location.href = this.href; // Redirect hanya jika dikonfirmasi
            }
        });
    });
});

function updateSlug() {
    let title = document.getElementById("title").value;
    let slug = title.toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '') // Hapus karakter khusus
                    .replace(/\s+/g, '-'); // Ganti spasi dengan "-"
    
    document.getElementById("slug").value = slug;
}
function addImageInput() {
    const imageInputs = document.getElementById('image-inputs');
    const newInput = document.createElement('div');
    newInput.classList.add('image-input');
    newInput.innerHTML = `
        <input type="file" name="images[]" accept="image/*" required>
        <select name="image_positions[]">
            <option value="top">Top</option>
            <option value="middle">Middle</option>
            <option value="bottom">Bottom</option>
        </select>
    `;
    imageInputs.appendChild(newInput);
}