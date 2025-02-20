Project by Yodha Ardiansyah
Instagram: @yodhaar_


/project-root
│── /public                             # Folder untuk file yang bisa diakses langsung oleh browser
│   ├── /css                            # File stylesheet (misalnya: styles.css)
│   │   ├── styles.css                  # styles untuk web utama
│   ├── /js                             # File JavaScript
│   │   ├── /script.js                  # pengaturan seluruh web utama
│   ├── /img                            # Gambar dan aset media lainnya
│   │   ├── /contact                    # Untuk menu contact
│   │   ├── /content                    # Untuk semua kegiatan/projek
│   │   ├── /icon                       # logo-logo
│   │   ├── /profile                    # untuk menu about me
│   ├── /fonts                          # Font khusus jika diperlukan
│   ├── index.php                       # Halaman utama dan yang diakses untuk memanggil header, footer, konten
│   ├── 
│   ├── /admin                          # Folder untuk halaman admin
│   │   ├── index.php                   # Dashboard utama admin
│   │   ├── login.php                   # Halaman login admin
│   │   ├── logout.php                  # Logout admin
│   │   ├── /css                        # CSS khusus admin
│   │   │   ├── admin.css
│   │   ├── /js                         # JavaScript untuk admin
│   │   │   ├── admin.js
│
│── /src                                # Sumber utama proyek (jika menggunakan framework)
│   ├── /components                     # Jika menggunakan React/Vue/Svelte
│   ├── /views                          # Halaman-halaman (jika menggunakan templating)
│   │   ├── /portfolio                  # Unutuk menu portofolio
│   │   │   ├── /category.php           # Untuk menampilkan berdasar tiap kategori dan merupakan bagian dari sub nav-bar
│   │   ├── /template                   # untuk template tampilan yang sering dipakai
│   │   │   ├── /categories.php         # Menyimpan semua kategori portofolio agar tidak berulang
│   │   │   ├── /footer.php             # untuk footer
│   │   │   ├── /hedaer.php             # untuk header
│   │   │   ├── /sub-navbar             # untuk sub-navbar yang tampil di menu portofolio dan semuanya di mode hp
│   │   ├── /admin                      # Template dan halaman admin
│   │   │   ├── dashboard.php           # Dashboard admin
│   │   │   ├── /template               # Template yang sering digunakan di admin
│   │   │   │   ├── header.php          # Header admin
│   │   │   │   ├── footer.php          # Footer admin
│   │   │   │   ├── sidebar.php         # Sidebar navigasi admin
│   │   │   ├── /category
│   │   │   │   ├── categories.php      # Manajemen kategori
│   │   │   │   ├── delete_category.php # menghapus kategori
│   │   │   │   ├── add_category.php    # menambah kategori
│   │   │   │   ├── edit_category.php   # edit kategori yang ada
│   │   │   ├── /content				# Manajemen konten
│   │   │   │   ├── 
│   │   │   │   ├──     
│   │   │   ├── /user
│   │   │   │   ├── users.php           # Manajemen user (opsional)
│   │   │   │   ├── add_user.php        # menmabah user
│   │   │   │   ├── delete_user.php     # hapus user
│   │   │   │   ├── edit_user.php       # edit user yang ada
│   │   │   │   ├──
│   │   ├── about.php                   # konten about me
│   │   ├── contact.php                 # konten contact
│   │   ├── detail.php                  # Untuk menampilkan tiap kegiatan / projek secara menyeluruh
│   │   ├── home.php                    # Tampilan awal
│   │   ├── portfolio.php               # Tampilan Untuk menampilkan kegiatan yang sudah dilakukan
│   ├── /styles                         # SASS/SCSS atau CSS modular
│   ├── /assets                         # Aset tambahan (ikon, ilustrasi)
│   ├── main.js                         # Masih kosong
│   ├── init.php                        # !function_exists('base_url')
│
│── /server                             # Jika ada backend
│   ├── /routes                         # Routing backend (Node.js, Laravel)
│   ├── /controllers                    # Logika backend
│   │   ├── AdminController.php         # Logika backend untuk admin
│   ├── /models                         # Struktur database (jika ada)
│   ├── /middlewares                    # Middleware (misalnya autentikasi)
│
│── /config                             # Konfigurasi (environment, database, API key, dll.)
│   ├── /function
│   │   ├── category.php                # 
│   │   │   ├── getCategories($conn) → Mengambil semua kategori
│   │   │   ├──  getCategoryById($conn, $id) → Mengambil kategori berdasarkan ID
│   │   │   ├──  addCategory($conn, $name, $slug) → Menambahkan kategori
│   │   │   ├──  updateCategory($conn, $id, $name, $slug) → Memperbarui kategori
│   │   │   ├──  deleteCategory($conn, $id) → Menghapus kategori
│   │   ├── content.php                 # 
│   │   ├── recent.php                  # 
│   │   │   ├──  getRecentContents($conn) → Mengambil 5 proyek terbaru
│   │   ├── slug.php                    # 
│   │   │   ├──  generateSlug($text) → Mengubah teks menjadi slug
│   │   │   ├──  slugExists($conn, $slug) → Mengecek apakah slug sudah ada
│   │   ├── statistics.php              # 
│   │   │   ├──  getTotalStats($conn) → Menghitung jumlah kategori, proyek, dan pengguna
│   │   ├── user.php                    # 
│   │   │   ├──  getUsers($conn) → Mengambil semua pengguna
│   │   │   ├──  getUserById($conn, $id) → Mengambil pengguna berdasarkan ID
│   │   │   ├──  addUser($conn, $username, $email, $password, $role) → Menambahkan pengguna
│   │   │   ├──  updateUser($conn, $id, $username, $email, $password, $role) → Memperbarui pengguna
│   │   │   ├──  deleteUser($conn, $id) → Menghapus pengguna
│   │   ├── utils.php                   # 
│   ├── init.php				        # !function_exists('base_url')
│   ├── init-admin.php			
│   ├── db.php                          # Konfigurasi ke database mysql
│   ├── auth.php                        # Konfigurasi autentikasi admin
│── /tests                              # Unit test dan integration test
│── /logs                               # Log aplikasi
│── /docs                               # Dokumentasi proyek
│── /scripts                            # Script otomatisasi (misalnya build/deploy)
│── package.json                        # Jika menggunakan Node.js atau frontend framework
│── .gitignore                          # File yang harus diabaikan Git
│── README.md                           # Dokumentasi singkat proyek
