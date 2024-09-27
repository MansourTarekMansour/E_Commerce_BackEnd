document.addEventListener("DOMContentLoaded", function(event) {
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
              nav = document.getElementById(navId),
              bodypd = document.getElementById(bodyId),
              headerpd = document.getElementById(headerId);

        // Load the sidebar state from localStorage
        // const isOpen = localStorage.getItem('sidebarOpen') === 'true';
        // if (isOpen) {
        //     nav.classList.add('open');
        //     nav.classList.add('show');
        //     bodypd.classList.add('body-pd');
        //     headerpd.classList.add('body-pd');
        //     toggle.classList.add('bx-x'); // Ensure the toggle button reflects the open state
        // }

        // Validate that all variables exist
        if (toggle && nav && bodypd && headerpd) {
            // Show navbar on mouse enter
            nav.addEventListener('mouseenter', () => {
                nav.classList.add('show');
                bodypd.classList.add('body-pd');
                headerpd.classList.add('body-pd');
            });

            // Hide navbar on mouse leave
            nav.addEventListener('mouseleave', () => {
                if (!nav.classList.contains('open')) { // Check if the sidebar is not open via button
                    nav.classList.remove('show');
                    bodypd.classList.remove('body-pd');
                    headerpd.classList.remove('body-pd');
                }
            });

            // Toggle sidebar visibility on button click
            toggle.addEventListener('click', () => {
                nav.classList.toggle('open'); // Toggle the open class
                toggle.classList.toggle('bx-x'); // Toggle the icon state

                if (nav.classList.contains('open')) {
                    nav.classList.add('show'); // Show the sidebar when opened via button
                    bodypd.classList.add('body-pd');
                    headerpd.classList.add('body-pd');
                    // Save the state to localStorage
                    localStorage.setItem('sidebarOpen', 'true');
                } else {
                    nav.classList.remove('show');
                    bodypd.classList.remove('body-pd');
                    headerpd.classList.remove('body-pd');
                    // Save the state to localStorage
                    localStorage.setItem('sidebarOpen', 'false');
                }
            });
        }
    }

    showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link');

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        }
    }

    linkColor.forEach(l => l.addEventListener('click', colorLink));
});

function updatePreview() {
    document.getElementById('preview_name').innerText = document.getElementById('name').value;
    document.getElementById('preview_description').innerText = document.getElementById('description').value;
    document.getElementById('preview_price').innerText = document.getElementById('price').value;
    document.getElementById('preview_discount_price').innerText = document.getElementById('discount_price').value || 'N/A';
    document.getElementById('preview_quantity_in_stock').innerText = document.getElementById('quantity_in_stock').value;
    document.getElementById('preview_category').innerText = document.getElementById('category_id').options[document.getElementById('category_id').selectedIndex].text;
    document.getElementById('preview_brand').innerText = document.getElementById('brand_id').options[document.getElementById('brand_id').selectedIndex].text;
}

function previewImages() {
    const files = document.getElementById('main_images').files;
    const preview = document.getElementById('image_preview');
    preview.innerHTML = ''; // Clear previous images

    if (files) {
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-fluid', 'me-2', 'mb-2');
                img.style.width = '100px'; // Set image width
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
}