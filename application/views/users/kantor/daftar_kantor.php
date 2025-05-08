<style>
  .branch {
    list-style: none;
    padding: 0;
    font-family: Arial, sans-serif;
  }

  .branch-item {
    list-style: none;
    border: 1px solid #e0e0e0;
    margin: 10px 0;
    padding: 10px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .branch-item:hover {
    background-color: #f5f5f5;
  }

  .branch-item a {
    text-decoration: none;
    font-weight: 500;
    color: #000;
  }

  .marker-icon {
    margin-right: 10px;
    font-size: 20px;
    background: linear-gradient(135deg, #ff3333, #ff9933);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    color: transparent;
  }

  .branch-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .branch-details {
    display: none;
    margin-top: 10px;
  }

  .branch-item.active .branch-details {
    display: block;
  }
</style>

<div class="container">
  <div class="content">
    <div class="row">
      <div class="panel panel-flat">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="panel-body">
          <!-- daftar_kantor.php -->

          <h2><b>Kantor KSPPS MELATI</b> </h2>

          <!-- Menampilkan daftar kantor dan pengguna berdasarkan kode_kantor -->
          <?php
          $kode_kantor_grouped = []; // Array untuk mengelompokkan kantor berdasarkan kode_kantor

          // Kelompokkan data kantor berdasarkan kode_kantor
          foreach ($kantor_data as $data) {
            $kode_kantor_grouped[$data->kode_kantor][] = $data;
          }

          foreach ($kode_kantor_grouped as $kode_kantor => $kantor_items) : ?>
            <div class="branch-item">
              <div class="branch-title">
                <h4>Kantor <?= ucwords($kantor_items[0]->nama_kantor) ?></h4> <!-- Menampilkan nama kantor -->
                <div class="marker-icon">&#9733;</div>
              </div>
              <div class="branch-details">
                <?php if (!empty($kantor_items[0]->alamat)) : ?>
                  <p><strong>Alamat:</strong> <?= nl2br($kantor_items[0]->alamat) ?></p>
                <?php else : ?>
                  <p>Alamat tidak tersedia</p>
                <?php endif; ?>

                <?php if (!empty($kantor_items[0]->telepon)) : ?>
                  <p>&#9742;<strong> Telepon:</strong> <?= $kantor_items[0]->telepon ?></p>
                <?php else : ?>
                  <p>Telepon tidak tersedia</p>
                <?php endif; ?>

                <?php if (!empty($kantor_items[0]->link_map)) : ?>
                  <a href="<?= $kantor_items[0]->link_map ?>" target="_blank">Lihat peta</a>
                <?php else : ?>
                  <p>Link peta tidak tersedia</p>
                <?php endif; ?>

                <hr style="margin-top:10px;margin-bottom:10px;">
                <ul>
                  <?php
                  // Menentukan level berdasarkan kode_kantor
                  if ($kode_kantor == '01') {
                    $levels = ['gm', 'mng_bisnis', 'kadiv_opr', 'kadiv_manrisk', 'kadiv_maal', 'fund_maal', 'k_admin', 'k_arsip', 'k_keuangan', 'k_hrd', 'ao', 'fo', 'audit', 'umum_dan_pengadaan', 'surveyor', 'it', 'ofb', 'satpam'];
                  } else {
                    $levels = ['k_cabang', 'admin', 'marketing', 'ao', 'fo', 'kadiv_maal', 'fund_maal', 'ofb', 'satpam'];
                  }

                  // Menampilkan role untuk kantor ini, hanya jika ada data pengguna
                  foreach ($levels as $level) {
                    $users = array_filter($kantor_items, function ($item) use ($level) {
                      return $item->level == $level;
                    });

                    if (!empty($users)) { // Jika ada pengguna untuk level ini, tampilkan
                      echo "<li><b>" . getLevelText($level) . "</b> : ";
                      foreach ($users as $user) {
                        echo ucwords($user->nama_lengkap) . ', ';
                      }
                      echo "</li>";
                    }
                  }
                  ?>
                </ul>
              </div>
            </div>
          <?php endforeach; ?>



        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const branchItems = document.querySelectorAll('.branch-item');

  branchItems.forEach((item) => {
    item.addEventListener('click', () => {
      item.classList.toggle('active');
    });
  });
</script>