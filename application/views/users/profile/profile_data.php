<?php
$tgl_daftar = $users->tgl_daftar;
$performa = $users->performa;
$filledStars = ($performa > 0) ? min($performa, 5) : 0;
$borderedStars = max(5 - $filledStars, 0);

// menghitung lama kerja
$date_daftar = new DateTime($tgl_daftar);
$date_now = new DateTime();
$interval = $date_daftar->diff($date_now);
$years = $interval->y;
$months = $interval->m;

// Social media links
$social_media = [
    'linkedin' => $users->linkedin ?? 'https://linkedin.com/',
    'twitter' => $users->twitter ?? 'https://twitter.com/',
    'instagram' => $users->instagram ?? 'https://instagram.com/',
    'facebook' => $users->facebook ?? 'https://facebook.com/'
];

$thumbnailURL = (!empty($users->foto_profile) && file_exists('./foto/foto_profile/' . $users->foto_profile)) ? './foto/foto_profile/' . $users->foto_profile : 'foto/default.png';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF0033;
            --primary-gradient: linear-gradient(135deg, #4F46E5, #818CF8);
            --text-color: #111827;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #F3F4F6;
            color: var(--text-color);
            line-height: 1.5;
        }

        h2 {
            margin-top: 0;
        }

        .container {
            width: 100%;
            margin: 1rem auto;
            padding: 0 1rem;
        }

        .profile-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, rgb(255, 0, 51), rgb(255, 153, 51));
            height: 100px;
        }

        .profile-content {
            display: flex;
            flex-wrap: wrap;
        }

        .profile-avatar-container {
            margin-top: -40px;
            padding: 0 1.5rem;
            flex: 0 0 140px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
            padding: 1rem 1.5rem 0.5rem 0;
        }

        .profile-name {
            margin-bottom: 0.25rem;
        }

        .profile-position {
            color: var(--text-muted);
        }

        .profile-rating {
            margin-bottom: 0.75rem;
        }

        .star {
            color: #FFD700;
            font-size: 0.875rem;
            margin-right: 2px;
        }

        .star-empty {
            color: #E5E7EB;
            font-size: 0.875rem;
            margin-right: 2px;
        }

        .social-links {
            display: flex;
            gap: 0.5rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: #F3F4F6;
            color: var(--primary-color);
            transition: all 0.2s ease;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .social-link:hover {
            background: var(--primary-color);
            color: white;
        }

        .profile-details {
            padding: 0.75rem 1.5rem 1.5rem;
        }

        .details-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .details-row:last-child {
            margin-bottom: 0;
        }

        .detail-item {
            display: flex;
            align-items: center;
            background-color: #F9FAFB;
            padding: 0.75rem;
            border-radius: 0.5rem;
            flex: 1;
        }

        .detail-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            color: white;
            font-size: 0.875rem;
            background: linear-gradient(135deg, rgb(255, 0, 51), rgb(255, 153, 51));
            border-radius: 0.375rem;
            margin-right: 0.75rem;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 0.125rem;
        }

        .detail-value {
            color: var(--text-color);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="profile-card">
            <div class="profile-header"></div>

            <div class="profile-content">
                <div class="profile-avatar-container">
                    <div class="profile-avatar" onclick="openProfileImage('<?php echo $thumbnailURL; ?>')">
                        <img src="<?php echo $thumbnailURL; ?>" alt="Profile Picture" loading="lazy" onerror="this.onerror=null; this.src='foto/default.png';">
                    </div>
                </div>

                <div class="profile-info">
                    <h2 class="profile-name"><?php echo htmlspecialchars($users->nama_lengkap); ?></h2>
                    <div class="profile-position"><?php echo $levelText = getLevelText($users->level); ?></div>

                    <div class="profile-rating">
                        <?php for ($i = 0; $i < $filledStars; $i++) : ?>
                            <i class="fas fa-star star"></i>
                        <?php endfor; ?>
                        <?php for ($i = 0; $i < $borderedStars; $i++) : ?>
                            <i class="far fa-star star-empty"></i>
                        <?php endfor; ?>
                    </div>

                    <!-- <div class="social-links">
                        <a href="<?php echo $social_media['linkedin']; ?>" class="social-link" target="_blank" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="<?php echo $social_media['twitter']; ?>" class="social-link" target="_blank" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="<?php echo $social_media['instagram']; ?>" class="social-link" target="_blank" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="<?php echo $social_media['facebook']; ?>" class="social-link" target="_blank" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div> -->
                </div>
            </div>

            <div class="profile-details">
                <!-- First Row -->
                <div class="details-row">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">CIF</div>
                            <div class="detail-value"><?php echo $users->nocif; ?></div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Telp</div>
                            <div class="detail-value"><?php echo $users->telp; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Second Row -->
                <div class="details-row">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Tanggal Masuk</div>
                            <div class="detail-value"><?php echo date('d-m-Y', strtotime($users->tgl_daftar)); ?></div>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Masa Kerja</div>
                            <div class="detail-value"><?php echo $years . ' tahun ' . $months . ' bulan'; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Third Row -->
                <div class="details-row">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Alamat</div>
                            <div class="detail-value"><?php echo $users->alamat; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        function openProfileImage(imageURL) {
            Swal.fire({
                imageUrl: imageURL,
                imageAlt: 'Profile Picture',
                showCloseButton: true,
                showConfirmButton: false,
                width: 'auto',
                padding: 0,
                background: '#ffffff',
                customClass: {
                    container: 'image-popup-container',
                    popup: 'image-popup',
                    closeButton: 'image-popup-close'
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add global styles for SweetAlert
            const style = document.createElement('style');
            style.textContent = `
                .swal2-popup {
                    border-radius: 0.5rem !important;
                    overflow: hidden !important;
                }
                .swal2-image {
                    margin: 0 !important;
                    max-height: 80vh !important;
                    max-width: 95vw !important;
                }
                .swal2-backdrop-show {
                    background: rgba(0, 0, 0, 0.75) !important;
                }
                .swal2-close {
                    position: absolute !important;
                    top: 10px !important;
                    right: 10px !important;
                    color: #111827 !important;
                    font-size: 1.5rem !important;
                    z-index: 100 !important;
                    opacity: 0.8 !important;
                }
                .swal2-close:hover {
                    opacity: 1 !important;
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>

</html>