<?php
$file_name = !empty($file_center['file_path']) ? basename($file_center['file_path']) : null;
?>

<style>
  label {
    font-weight: bold;
  }

  .file-preview {
    width: 100%;
    border: 1px solid #ccc;
    overflow-x: auto;
    /* Allow horizontal scrolling */
    margin-bottom: 20px;
    position: relative;
    /* Allow positioning of the float button */
  }

  .file-preview canvas {
    display: block;
    margin: 0 auto;
    width: auto;
    /* Allow the canvas to exceed its container */
    height: auto;
    border: 1px solid #ddd;
    /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
  }


  .image-preview {
    display: block;
    margin: 0 auto;
    /* Center the image */
    max-width: 100%;
    max-height: 500px;
    /* Adjust height as needed */
    border-radius: 10px;
  }

  .loader {
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #3498db;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin: 20px auto;
    display: block;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  .loading-message {
    text-align: center;
    margin-top: 20px;
    font-size: 18px;
    font-weight: bold;
    color: #555;
  }

  .loading-message small {
    font-size: 12px;
    color: #888;
  }

  .float-buttons {
    position: fixed;
    bottom: 100px;
    right: 20px;
    z-index: 1000;
    transition: opacity 0.3s;
    /* Tambahkan transisi untuk efek fade */
  }

  .float-buttons-aksi {
    position: fixed;
    bottom: 100px;
    left: 20px;
    z-index: 1000;
    transition: opacity 0.3s;
    /* Tambahkan transisi untuk efek fade */
  }

  .float-buttons-navigasi {
    position: fixed;
    top: 30px;
    left: 20px;
    z-index: 1000;
    transition: opacity 0.3s;
    background-color: #F2F3F5;
    border-radius: 5px;
  }

  .float-buttons.hidden {
    opacity: 0;
    /* Sembunyikan tombol dengan opacity 0 */
    pointer-events: none;
    /* Nonaktifkan interaksi ketika tersembunyi */
  }

  .zoom-btn {
    background-color: #F2F3F5;
    /* Add transparency */
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px;
    /* Add spacing between buttons */
    transition: background-color 0.3s;
    /* Smooth transition for hover effect */
  }

  .zoom-btn:hover {
    background-color: rgba(128, 128, 128, 0.8);
    /* Slightly darker on hover */
  }

  .file-info {
    padding: 15px;
    background-color: #f1f1f1;
    border-radius: 8px;
    margin-bottom: 20px;
  }

  .form-group {
    margin-bottom: 15px;
  }

  .form-group label {
    margin-bottom: 5px;
    display: block;
  }

  .form-group span {
    display: block;
    word-wrap: break-word;
  }

  .container {
    width: 100%;
    margin: 0;
    padding: 0;
  }
</style>

<div class="container">
  <!-- Content area -->
  <div class="content">
    <?php echo $this->session->flashdata('msg'); ?>

    <!-- Detail File Center content -->
    <div class="row">
      <div class="panel panel-flat">

        <!-- File Preview Section -->
        <?php if (!empty($file_center['file_path'])) : ?>
          <?php $file_url = site_url('files/' . $file_name); ?>
          <?php if (strpos($file_center['file_type'], 'image/') === 0) : ?>
            <img src="<?php echo $file_url; ?>" alt="Image" class="image-preview" loading="lazy" />
          <?php elseif ($file_center['file_type'] === 'application/pdf') : ?>
            <div class="file-preview">
              <!-- Loader while loading the PDF -->
              <div id="loadingSpinner" class="loader"></div>
              <div id="loadingMessage" class="loading-message">
                <p>Loading PDF...</p>
              </div>
              <div id="fileViewer" style="display: none;"></div>
              <div class="float-buttons" id="floatButtons">
                <button id="zoomOut" class="zoom-btn">
                  <i class="fa fa-search-minus"></i> <!-- Ikon untuk zoom out -->
                </button>
                <button id="zoomIn" class="zoom-btn">
                  <i class="fa fa-search-plus"></i> <!-- Ikon untuk zoom in -->
                </button>
              </div>
            </div>
          <?php else : ?>
            <p>File type not supported for viewing.</p>
          <?php endif; ?>
        <?php else : ?>
          <p>Tidak ada file untuk ditampilkan.</p>
        <?php endif; ?>

        <div class="float-buttons-navigasi" id="floatButtons-navigasi">
          <a href="javascript:void(0);" class="btn btn-secondary" onclick="history.back();">
            <i class="fa fa-arrow-left"></i>
          </a>
        </div>

        <div class="float-buttons-aksi" id="floatButtons-aksi" style="margin-bottom: 7px;">
          <button id="infoBtn" class="btn btn-info">
            <i class="fa fa-info-circle"></i>
          </button>
          <?php if ($file_center['download_status'] == 1) : ?>
            <a href="<?php echo site_url('users/file_center_download/' . $file_center['id']); ?>" class="btn btn-success">
              <i class="fa fa-download"></i>
            </a>
          <?php endif; ?>
          <?php
          // Define the allowed levels
          $allowedLevels = ['mng_bisnis', 'kadiv_manrisk', 'kadiv_opr', 's_admin'];

          // Check if the user's level is in the allowed levels
          if (in_array($user->row()->level, $allowedLevels)) :
          ?>
            <a href="<?php echo site_url('users/file_center_edit/' . $file_center['id']); ?>" class="btn btn-primary">
              <i class="fa fa-pencil"></i>
            </a>
            <a href="<?php echo site_url('users/file_center_hapus/' . $file_center['id']); ?>" class="btn btn-danger delete-btn" data-id="<?php echo $file_center['id']; ?>">
              <i class="fa fa-trash"></i>
            </a>
          <?php endif; ?>
        </div>

      </div>
    </div>
    <!-- /File Center content -->
  </div>
  <!-- /content area -->
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

<script async>
  document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const infoBtn = document.getElementById('infoBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const loadingMessage = document.getElementById('loadingMessage');
    const fileViewer = document.getElementById('fileViewer'); // Div container for rendering pages
    const fileUrl = "<?php echo $file_url; ?>"; // URL to the PDF file
    let lastScrollTop = 0; // Menyimpan posisi gulir terakhir
    const floatButtons = document.getElementById('floatButtons');
    const floatButtonsAksi = document.getElementById('floatButtons-aksi');
    const floatButtonsNavigasi = document.getElementById('floatButtons-navigasi');

    let currentScale = 1; // Initial scale
    const scaleFactor = 0.1; // Amount to change zoom per click
    let pdfDoc = null; // Store the loaded PDF document
    let canvasElements = []; // Store the canvas elements to scale them during zoom

    // Handle delete button functionality
    deleteButtons.forEach(button => {
      button.addEventListener('click', function(event) {
        event.preventDefault();

        const deleteUrl = button.getAttribute('href');
        const dataId = button.getAttribute('data-id');

        Swal.fire({
          title: 'Apakah Anda yakin?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = deleteUrl;
          }
        });
      });
    });

    // Handle info button functionality
    infoBtn.addEventListener('click', function() {
      Swal.fire({
        title: 'Informasi File',
        html: `
          <div class="file-info">
              <div class="row">
                  <div class="col-xs-6 col-sm-6 form-group">
                      <label for="uploaded_at">Tanggal Unggah:</label>
                      <span><?php echo $file_center['uploaded_at'] ? date('d-m-Y', strtotime($file_center['uploaded_at'])) : 'Tanggal tidak tersedia'; ?></span>
                  </div>
                  <div class="col-xs-6 col-sm-6 form-group">
                      <label for="file_name">Nama File:</label>
                      <span><?php echo !empty($file_center['file_path']) ? htmlspecialchars($file_name) : '-'; ?></span>
                  </div>
                  <div class="col-xs-6 col-sm-6 form-group">
                      <label for="file_size">File size:</label>
                      <span><?php echo $file_center['file_size']; ?> KB</span>
                  </div>
                  <div class="col-xs-6 col-sm-6 form-group">
                      <label for="description">Deskripsi:</label>
                      <span><?php echo htmlspecialchars($file_center['description']); ?></span>
                  </div>
                  <div class="col-xs-6 col-sm-6 form-group">
                      <label for="uploaded_by">Uploaded by:</label>
                      <span><?php echo htmlspecialchars($file_center['uploaded_by']); ?></span>
                  </div>
              </div>
          </div>
        `,
        showCloseButton: true,
        focusConfirm: false
      });
    });

    // Load the PDF file using PDF.js
    const loadingTask = pdfjsLib.getDocument(fileUrl);

    loadingTask.promise.then(function(pdf) {
      // Hide loader after the PDF is loaded
      loadingSpinner.style.display = 'none';
      loadingMessage.style.display = 'none';
      fileViewer.style.display = 'block';
      pdfDoc = pdf;

      const totalPages = pdf.numPages; // Get the total number of pages in the PDF

      // Get the viewport scale to fit PDF width to the container width
      pdf.getPage(1).then(function(page) {
        const viewport = page.getViewport({
          scale: 1
        });
        const containerWidth = fileViewer.offsetWidth;
        currentScale = containerWidth / viewport.width; // Adjust scale to fit container width

        // Render all pages using the calculated scale
        for (let pageNumber = 1; pageNumber <= totalPages; pageNumber++) {
          renderPage(pdf, pageNumber);
        }
      });
    }).catch(function(error) {
      // Handle any errors that occur while loading the PDF
      loadingSpinner.style.display = 'none';
      loadingMessage.innerHTML = 'Error loading PDF. Please try again later.';
      console.error('Error loading PDF:', error);
    });

    // Function to render each page
    function renderPage(pdf, pageNumber) {
      pdf.getPage(pageNumber).then(function(page) {
        const viewport = page.getViewport({
          scale: currentScale
        });

        // Create a canvas element for each page
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        // Set the canvas size to the viewport size with devicePixelRatio for higher resolution
        const outputScale = window.devicePixelRatio || 1;
        canvas.width = Math.floor(viewport.width * outputScale);
        canvas.height = Math.floor(viewport.height * outputScale);
        canvas.style.width = `${viewport.width}px`;
        canvas.style.height = `${viewport.height}px`;

        // Apply the scale to maintain sharpness
        const transform = [outputScale, 0, 0, outputScale, 0, 0];
        const renderContext = {
          canvasContext: context,
          viewport: viewport,
          transform: transform // Apply the transformation for high-resolution rendering
        };

        fileViewer.appendChild(canvas);
        canvasElements.push(canvas); // Store the canvas for zooming later

        page.render(renderContext).promise.then(function() {
          if (<?php echo $file_center['download_status']; ?> === 0) {
              addWatermark(context, canvas.width, canvas.height);
          }
        });
      });
    }

    // Function to add watermark to the canvas
    function addWatermark(context, width, height) {
      const watermarkText = 'DOKUMEN RAHASIA'; // Example watermark text
      context.save(); // Save the current state
      context.font = '100px Arial';
      context.fillStyle = 'rgba(0, 0, 0, 0.15)'; // Light gray with transparency
      context.textAlign = 'center';
      context.textBaseline = 'middle';
      context.translate(width / 2, height / 2); // Center watermark
      context.rotate(-45 * Math.PI / 180); // Rotate watermark
      context.fillText(watermarkText, 0, 0); // Draw watermark
      context.restore(); // Restore to original state
    }

    // Zoom In button
    document.getElementById('zoomIn').addEventListener('click', function() {
      currentScale += scaleFactor; // Increase scale
      scaleCanvasElements(); // Scale the existing canvas elements
    });

    // Zoom Out button
    document.getElementById('zoomOut').addEventListener('click', function() {
      if (currentScale > scaleFactor) {
        currentScale -= scaleFactor; // Decrease scale
        scaleCanvasElements(); // Scale the existing canvas elements
      }
    });

    // Function to scale existing canvas elements without reloading the PDF
    function scaleCanvasElements() {
      canvasElements.forEach(function(canvas) {
        const context = canvas.getContext('2d');
        const outputScale = window.devicePixelRatio || 1;
        const pageNumber = canvasElements.indexOf(canvas) + 1;

        pdfDoc.getPage(pageNumber).then(function(page) {
          const viewport = page.getViewport({
            scale: currentScale
          });

          // Resize the canvas dimensions
          canvas.width = Math.floor(viewport.width * outputScale);
          canvas.height = Math.floor(viewport.height * outputScale);
          canvas.style.width = `${viewport.width}px`;
          canvas.style.height = `${viewport.height}px`;

          // Re-render the page on the resized canvas
          const renderContext = {
            canvasContext: context,
            viewport: viewport,
            transform: [outputScale, 0, 0, outputScale, 0, 0] // Apply the transformation again
          };

          page.render(renderContext).promise.then(function() {
            if (<?php echo $file_center['download_status']; ?> === 0) {
              addWatermark(context, canvas.width, canvas.height);
          }
          });
        });
      });
    }

    // Handle scroll to hide and show floating buttons
    window.addEventListener('scroll', function() {
      const scrollTop = window.scrollY || document.documentElement.scrollTop;

      if (scrollTop > lastScrollTop) {
        // Hide buttons when scrolling down
        floatButtons.classList.add('hidden');
        floatButtonsAksi.classList.add('hidden');
        floatButtonsNavigasi.classList.add('hidden');
      } else {
        // Show buttons when scrolling up
        floatButtons.classList.remove('hidden');
        floatButtonsAksi.classList.remove('hidden');
        floatButtonsNavigasi.classList.remove('hidden');
      }
      lastScrollTop = scrollTop;
    });
    
  });
</script>

