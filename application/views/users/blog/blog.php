<style>
    /* CSS untuk membuat konten responsif */
    #wordpress-content {
        max-width: 100%;
        padding: 20px;
    }

    /* CSS untuk membuat judul responsif */
    #wordpress-content h2 {
        text-align: left;
        font-size: 24px;
        margin-top: 20px;
        margin-bottom: 10px;
        font-weight: bold;
    }

    #wordpress-content h3 {
        font-size: 16px;
        text-align: left;
        font-weight: bold;
    }

    /* CSS untuk membuat konten responsif */
    #wordpress-content div {
        font-size: 16px;
        line-height: 1.5;
    }

    .lazy-load-img {
        display: none;
    }

    /* CSS untuk membuat gambar responsif */
    #wordpress-content img {
        max-width: 100%;
        /* Pastikan gambar tidak melebihi lebar kontainer */
        height: auto;
        /* Biarkan tinggi gambar disesuaikan dengan proporsi aslinya */
        display: block;
        /* Hilangkan margin dan padding dari gambar */
        margin: 0 auto;
        /* Tengahkan gambar dalam kontainer jika perlu */
        border-radius: 10px;
    }

    /* Media query untuk tampilan responsif pada layar kecil */
    @media (max-width: 768px) {

        /* Sesuaikan gaya sesuai dengan kebutuhan Anda */
        #wordpress-content {
            padding: 10px;
            font-size: 14px;
        }

        #wordpress-content h2 {
            font-size: 20px;
        }

        #wordpress-content div {
            font-size: 14px;
        }
    }

    /* CSS untuk membuat judul lebih tebal */
    #wordpress-content h2 {
        font-size: 24px;
        margin-top: 20px;
        margin-bottom: 10px;
        font-weight: bold;
        /* Mengatur judul menjadi lebih tebal */
    }


    /* CSS untuk membuat teks rata kiri-kanan */
    #wordpress-content div {
        font-size: 14px;
        line-height: 1.5;
        max-width: 100%;
        text-align: justify;
        /* Mengatur teks menjadi rata kiri-kanan */
    }

    /* CSS untuk membuat elemen figure dan gambar di dalamnya responsif */
    .wp-caption {
        max-width: 100%;
        width: auto;
    }

    .wp-caption img {
        max-width: 100%;
        height: auto;
    }

</style>


<!-- Main content -->
<div class="content-wrapper">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="container">
            <!-- Blog content -->
            <div class="row">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div id="wordpress-content"></div>
                    </div>
                </div>
            </div>
            <!-- /Blog content -->
        </div>
    </div>
    <!-- /content area -->
</div>
<!-- /main content -->

<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mendapatkan ID postingan dari URL
            const url = window.location.href;
            const postId = url.substring(url.lastIndexOf('/') + 1);

            // Ganti URL dengan URL API WordPress yang sesuai
            const apiUrl = `https://bmtmelati.com/wp-json/wp/v2/posts/${postId}`;

            // Lakukan permintaan AJAX ke API WordPress untuk mendapatkan satu postingan
            $.ajax({
                url: apiUrl,
                method: 'GET',
                success: function (post) {
                    const wordpressContent = document.getElementById('wordpress-content');

                    // Ambil judul dan konten postingan dari respons JSON
                    const postTitle = post.title.rendered;
                    const postContent = post.content.rendered;

                    // Buat elemen untuk judul postingan
                    const titleElement = document.createElement('h2');
                    titleElement.textContent = postTitle;

                    // Buat elemen untuk konten postingan
                    const contentElement = document.createElement('div');
                    contentElement.innerHTML = postContent;

                    // Tambahkan elemen judul dan konten ke tampilan
                    wordpressContent.appendChild(titleElement);
                    wordpressContent.appendChild(contentElement);

                    // Add lazy loading to images
                    const lazyLoadImages = contentElement.querySelectorAll('img.lazy-load-img');
                    lazyLoadImages.forEach((img) => {
                        img.classList.add('lazy-load-img');
                        img.setAttribute('data-src', img.src);
                        img.removeAttribute('src');
                        img.loading = 'lazy'; // Native lazy loading
                    });

                    // Intersection Observer to load images when they come into view
                    const observer = new IntersectionObserver((entries, observer) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                const lazyImage = entry.target;
                                lazyImage.src = lazyImage.dataset.src;
                                lazyImage.classList.remove('lazy-load-img');
                                observer.unobserve(lazyImage);
                            }
                        });
                    });

                    lazyLoadImages.forEach((img) => {
                        observer.observe(img);
                    });
                },
                error: function (error) {
                    console.error('Error fetching WordPress post:', error);
                }
            });
        });
    </script>