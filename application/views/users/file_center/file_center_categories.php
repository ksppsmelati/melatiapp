<?php
$cek = $user->row(); // Mengambil nilai data dari tabel tbl_user 
$level = $cek->level; // Nilai level dari variabel $level
?>

<style>
    .folder-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        /* Jarak antar folder */
        justify-content: flex-start;
    }

    .folder-item {
        flex: 1 1 calc(25% - 20px);
        /* Set 4 ikon per baris dengan gap */
        max-width: calc(25% - 20px);
        text-align: center;
        cursor: pointer;
    }

    .folder-link {
        display: block;
        text-decoration: none;
        color: #333;
    }

    .folder-icon {
        font-size: 60px;
        color: #ffcc00;
        /* Warna icon folder */
    }

    .folder-name {
        font-size: 12px;
        word-wrap: break-word;
    }

    .folder-item:hover .folder-icon {
        color: #ffaa00;
    }

    .folder-item:hover .folder-name {
        color: #007bff;
    }

    @media (min-width: 1200px) {
        .folder-item {
            flex: 1 1 calc(12.5% - 20px);
            /* 8 ikon per baris pada layar lebar */
            max-width: calc(12.5% - 20px);
        }
    }

    @media (max-width: 768px) {
        .folder-item {
            flex: 1 1 calc(50% - 20px);
            /* 2 ikon per baris pada layar kecil */
        }
    }

    @media (max-width: 480px) {
        .folder-item {
            flex: 1 1 calc(100% - 20px);
            /* 1 ikon per baris pada layar sangat kecil */
        }
    }

    .search-container {
        margin-bottom: 20px;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .reset-search {
        position: absolute;
        right: 10px;
        top: 10px;
        cursor: pointer;
        color: #aaa;
        font-size: 18px;
        display: none;
    }

    th {
        font-weight: bold;
    }
</style>

<div class="container">
    <!-- Content area -->
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <!-- Data File Center content -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="navigation-buttons">
                        <div class="btn-group" style="float: left;">
                            <!-- Tombol Back (di pojok kiri atas) -->
                            <i class="fa fa-folder"></i> Data File Center
                        </div>

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <!-- <li><a href="<?php echo site_url('users/file_center_upload'); ?>"><i class="fa fa-plus"></i> Tambah File</a></li> -->
                                <li><a href="<?php echo site_url('users/file_center_categories'); ?>"><i class="fa fa-file"></i> Data File Center</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <div class="clearfix"></div>
                    <?php
                    $allowedLevels = ['mng_bisnis', 'kadiv_manrisk', 'kadiv_opr', 's_admin', 'k_hrd', 'k_arsip'];
                    if (in_array($user->row()->level, $allowedLevels)) {
                        echo '<a href="users/file_center_upload" class="btn btn-danger mb-3"><i class="fa fa-upload"></i> Upload</a>';
                    }
                    ?>
                    <hr>
                    <div class="search-container">
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari File..." />
                        <span class="reset-search" id="reset-search">&times;</span>
                    </div>

                    <div class="folder-grid" id="categoryGrid">
                        <!-- Looping kategori -->
                        <?php foreach ($categories as $category) : ?>
                            <div class="folder-item">
                                <a href="<?php echo site_url('users/file_center_by_category/' . rawurlencode($category)); ?>" class="folder-link">
                                    <div class="folder-icon">
                                        <i class="fa fa-folder"></i>
                                    </div>
                                    <div class="folder-name">
                                        <?php echo $category; ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="table-responsive" id="fileTable" style="display: none;">
                    <table class="table" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama File</th>
                                <th>Kategori</th>
                                <th>Tahun</th>
                                <th>Size</th>
                                <th>Keterangan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="fileTableBody">
                            <?php $no = 1;
                            foreach ($file_center as $file) : ?>
                                <tr class="file-row" data-file-name="<?php echo htmlspecialchars($file['file_name']); ?>" data-category="<?php echo $file['category']; ?>" data-size="<?php echo $file['file_size']; ?>" data-description="<?php echo htmlspecialchars_decode(substr(strip_tags($file['description']), 0, 25) . (strlen($file['description']) > 25 ? '...' : '')); ?>">
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('users/file_center_lihat/' . $file['id']); ?>">
                                            <?php echo htmlspecialchars($file['file_name']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo $file['category']; ?></td>
                                    <td><?php echo $file['tahun']; ?></td>
                                    <td><?php echo $file['file_size']; ?> KB</td>
                                    <td><?php echo htmlspecialchars_decode(substr(strip_tags($file['description']), 0, 25) . (strlen($file['description']) > 25 ? '...' : '')); ?></td>
                                    <td>
                                        <a href="<?php echo site_url('users/file_center_lihat/' . $file['id']); ?>" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <?php if ($file['download_status'] == 1) : ?>
                                            <a href="<?php echo site_url('users/file_center_download/' . $file['id']); ?>" class="btn btn-success btn-sm">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (in_array($user->row()->level, $allowedLevels)) : ?>
                                            <a href="<?php echo site_url('users/file_center_edit/' . $file['id']); ?>" class="btn btn-primary btn-sm">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            <a href="<?php echo site_url('users/file_center_hapus/' . $file['id']); ?>" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $file['id']; ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Data File Center content -->
    </div>
    <!-- /content area -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById("searchInput");
        const categoryGrid = document.getElementById("categoryGrid");
        const fileTable = document.getElementById("fileTable");
        const fileTableBody = document.getElementById("fileTableBody");
        const fileRows = document.querySelectorAll('.file-row');
        const folderItems = document.querySelectorAll('.folder-item'); // Folder items
        const resetButton = document.getElementById("reset-search");

        searchInput.addEventListener("keyup", function() {
            const filter = searchInput.value.toLowerCase();
            let hasResults = false;
            let categoryMatch = false; // Check for folder match

            // Clear previous results in the file table
            fileTableBody.innerHTML = '';

            // Search for matching files
            fileRows.forEach(row => {
                const fileName = row.getAttribute('data-file-name').toLowerCase();
                const category = row.getAttribute('data-category').toLowerCase();
                const size = row.getAttribute('data-size').toLowerCase();
                const description = row.getAttribute('data-description').toLowerCase();

                // Check if the search term matches any of the criteria
                if (fileName.includes(filter) || category.includes(filter) || size.includes(filter) || description.includes(filter)) {
                    hasResults = true;
                    const newRow = row.cloneNode(true);
                    fileTableBody.appendChild(newRow);
                }
            });

            // Check for folder match
            folderItems.forEach(folder => {
                const folderName = folder.querySelector('.folder-name').textContent.toLowerCase();
                if (folderName.includes(filter)) {
                    folder.style.display = 'block';
                    categoryMatch = true;
                } else {
                    folder.style.display = 'none';
                }
            });

            // Show/hide category grid and file table based on results
            if (hasResults || categoryMatch) {
                categoryGrid.style.display = 'flex'; // Display if category matches or file results exist
                fileTable.style.display = hasResults ? 'block' : 'none';
            } else {
                categoryGrid.style.display = 'flex'; // Show all categories if no results
                fileTable.style.display = 'none';
            }

            // Show/hide reset button based on input
            resetButton.style.display = filter ? 'block' : 'none';
        });

        resetButton.addEventListener("click", function() {
            searchInput.value = '';
            resetButton.style.display = 'none';
            categoryGrid.style.display = 'flex'; // Show all folders
            fileTable.style.display = 'none'; // Hide file results
            folderItems.forEach(folder => folder.style.display = 'block'); // Show all folders
        });
    });
</script>