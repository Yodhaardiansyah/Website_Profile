// Function untuk memuat file eksternal ke dalam halaman
function loadComponent(file, elementId) {
    fetch(file)
        .then(response => response.text())
        .then(data => {
            document.getElementById(elementId).innerHTML = data;
        })
        .catch(error => console.error('Error loading ' + file, error));
}

// Animasi Scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Hover Effect pada Tombol
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            button.style.transform = 'scale(1.1)';
        });

        button.addEventListener('mouseleave', () => {
            button.style.transform = 'scale(1)';
        });
    });

    // Dynamic Text Animation
    const dynamicText = document.querySelector('.dynamic-text');
    if (dynamicText) {
        const texts = [ "Yodha Ardiansyah","Welcome!", "Explore My Portfolio"];
        let index = 0;

        function changeText() {
            dynamicText.innerText = texts[index]; // Menggunakan innerText agar aman
            index = (index + 1) % texts.length;
        }

        setInterval(changeText, 2000);
    }
});


document.querySelectorAll('.category-link').forEach(link => {
    link.addEventListener('click', function(event) {
        // Jangan gunakan preventDefault() jika tidak diperlukan
        console.log('Link clicked:', this.href);
    });
});

// sub nav bar
function toggleSubMenu() {
    var menu = document.getElementById("subnav-list");
    menu.classList.toggle("active");
}

window.addEventListener("scroll", function () {
    var subNavbar = document.querySelector(".sub-navbar");
    
    var footer = document.querySelector(".social-footer");

    if (footer) {
        var footerTop = footer.getBoundingClientRect().top;
        var windowHeight = window.innerHeight;

        // Jika footer terlihat di layar, sembunyikan navbar
        if (footerTop < windowHeight) {
            subNavbar.classList.add("hidden");
        } else {
            subNavbar.classList.remove("hidden");
        }
    }
});


