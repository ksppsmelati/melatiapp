<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    :root {
        --primary-color: #128C7E;
        --secondary-color: #25D366;
        --light-color: #DCF8C6;
        --dark-color: #075E54;
        --text-color: #4a4a4a;
        --border-radius: 8px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f0f2f5;
        color: var(--text-color);
    }

    .container {
        max-width: 500px;
        margin: 0 auto;
        background: white;
        height: calc(100vh - 56px);
        /* Subtract navigation bar height */
        position: relative;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
        background-color: #ff3333;
        color: white;
        padding: 5px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .header h2 {
        margin-left: 15px;
        font-size: 1.2rem;
        font-weight: 500;
    }

    .back-btn {
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .camera-container {
        height: calc(100% - 55px);
        /* Adjusted for header */
        background-color: #000;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #camera-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #preview-image {
        max-width: 100%;
        max-height: 100%;
        display: none;
    }

    #preview-video {
        max-width: 100%;
        max-height: 100%;
        display: none;
    }

    .camera-overlay {
        position: absolute;
        bottom: 30px;
        /* Increased to avoid potential overlap with navigation */
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .camera-controls {
        display: flex;
        width: 100%;
        justify-content: space-between;
        align-items: center;
        padding: 0 40px;
    }

    .left-controls,
    .right-controls {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .capture-btn-container {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .capture-btn {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: white;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        z-index: 10;
    }

    .capture-btn .inner-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 3px solid #ccc;
    }

    .gallery-btn,
    .next-btn,
    .retake-btn,
    .text-story-btn {
        color: white;
        font-size: 24px;
        cursor: pointer;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 50%;
    }

    .flash-btn,
    .flip-btn {
        color: white;
        font-size: 24px;
        cursor: pointer;
        margin-bottom: 16px;
    }

    .form-container {
        padding: 15px;
        display: none;
        height: calc(100% - 55px);
        /* Match camera container height */
    }

    .text-story-container {
        padding: 15px;
        display: none;
        height: calc(100% - 55px);
        background-color: #f0f2f5;
    }

    .text-style-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 15px;
    }

    .text-background {
        width: 20px;
        height: 20px;
        border-radius: 10px;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .text-background.active {
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #000;
    }

    .font-style {
        padding: 5px 10px;
        border-radius: 15px;
        background-color: #e6e6e6;
        cursor: pointer;
    }

    .font-style.active {
        background-color: #ff3333;
        color: white;
    }

    .text-preview {
        margin-top: 10px;
        height: 350px;
        background-color: #128C7E;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
    }

    .preview-text {
        width: 100%;
        text-align: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
        word-wrap: break-word;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        resize: none;
        font-size: 16px;
        margin-bottom: 15px;
        height: 120px;
    }

    .submit-btn {
        background-color: #ff3333;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: var(--border-radius);
        font-size: 16px;
        cursor: pointer;
        width: 100%;
        font-weight: 500;
    }

    .submit-btn:hover {
        background-color: #ff9933;
    }

    .file-input-container {
        display: none;
    }

    .top-actions {
        position: absolute;
        top: 15px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 15px;
        z-index: 10;
    }

    .mode-selection {
        display: flex;
        justify-content: center;
        padding: 5px 0;
        background-color: #ff3333;
    }

    .mode-option {
        padding: 8px 16px;
        margin: 0 10px;
        color: white;
        font-weight: 500;
        cursor: pointer;
        border-radius: 20px;
    }

    .mode-option.active {
        background-color: white;
        color: #ff3333;
    }

    .action-btn {
        color: white;
        font-size: 22px;
        cursor: pointer;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .error-message {
        color: red;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .loading-spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid var(--primary-color);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="container">
    <?php echo form_open_multipart('users/story_upload', ['id' => 'story-form', 'accept-charset' => 'utf-8']); ?>

    <!-- <div class="header">
        <a href="<?php echo base_url('users/story_data'); ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2>Add to My Story</h2>
    </div> -->

    <div class="mode-selection" style="display: none;">
        <div class="mode-option active" id="media-mode">Media</div>
        <div class="mode-option" id="text-mode">Text</div>
    </div>

    <div class="camera-container" id="camera-container">
        <!-- Camera preview will be shown here -->
        <video id="camera-preview" autoplay></video>
        <img id="preview-image" src="" alt="Preview">
        <video id="preview-video" controls></video>

        <div class="top-actions">
            <div class="action-btn flash-btn" id="flash-btn">
                <i class="fas fa-bolt"></i>
            </div>
            <div class="action-btn flip-btn">
                <i class="fas fa-sync-alt"></i>
            </div>
        </div>

        <div class="camera-overlay">
            <div class="camera-controls">
                <!-- Left side - Empty or retake button when image is captured -->
                <div class="left-controls">
                    <div class="retake-btn" id="retake-btn" style="display: none;">
                        <i class="fas fa-undo"></i>
                    </div>
                    <div class="text-story-btn" id="text-story-btn">
                        <i class="fas fa-font"></i>
                    </div>
                </div>

                <!-- Center - Always capture button -->
                <div class="capture-btn-container">
                    <div class="capture-btn" id="capture-btn">
                        <div class="inner-circle"></div>
                    </div>
                </div>

                <!-- Right side - Gallery before capture, Next button after capture -->
                <div class="right-controls">
                    <div class="gallery-btn" id="gallery-btn">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="next-btn" id="next-btn" style="display: none;">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-story-container" id="text-story-container">
        <div class="text-preview">
            <div class="preview-text" id="preview-text">Type your text above to preview</div>
        </div>
        <br>
        <div class="text-style-options">
            <div class="text-background active" style="background-color: #128C7E;" data-color="#128C7E"></div>
            <div class="text-background" style="background-color: #075E54;" data-color="#075E54"></div>
            <div class="text-background" style="background-color: #25D366;" data-color="#25D366"></div>
            <div class="text-background" style="background-color: #34B7F1;" data-color="#34B7F1"></div>
            <div class="text-background" style="background-color: #FF3333;" data-color="#FF3333"></div>
            <div class="text-background" style="background-color: #FF9933;" data-color="#FF9933"></div>
            <div class="text-background" style="background-color: #6A0DAD;" data-color="#6A0DAD"></div>
            <div class="text-background" style="background-color: #000000;" data-color="#000000"></div>
        </div>

        <div class="text-style-options">
            <div class="font-style active" data-font="'Segoe UI', sans-serif">Default</div>
            <div class="font-style" data-font="Arial, sans-serif">Arial</div>
            <div class="font-style" data-font="Georgia, serif">Georgia</div>
            <div class="font-style" data-font="'Comic Sans MS', cursive">Comic</div>
        </div>

        <textarea id="text-story-input" placeholder="Type your status..."></textarea>
        <br>
        <button type="button" class="submit-btn" id="text-story-submit">
            <i class="fas fa-paper-plane"></i> Share Text Story
        </button>
    </div>

    <div class="form-container" id="caption-container">
        <?php if (isset($error)) { ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>

        <textarea name="caption" id="caption" placeholder="Add a caption..." rows="4"></textarea>
        <button type="submit" class="submit-btn">
            <i class="fas fa-paper-plane"></i> Share Story
        </button>
    </div>

    <div class="file-input-container">
        <input type="file" name="file_story" id="file_story" accept="image/*,video/*" />
        <input type="hidden" name="story_type" id="story_type" value="media" />
        <input type="hidden" name="text_background" id="text_background" value="#128C7E" />
        <input type="hidden" name="text_font" id="text_font" value="'Segoe UI', sans-serif" />
    </div>
    <?php echo form_close(); ?>

    <button id="btnNewAction" onclick="handleNewAction()" class="float" style="visibility: hidden;">
    <i class="fa fa-check-circle" style="font-size: 30px;"></i>
</button>
</div>

<div class="loading" id="loading-screen">
    <div class="loading-spinner"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/compressorjs/1.1.1/compressor.min.js"></script>
<script>
    // DOM Elements
    const cameraPreview = document.getElementById('camera-preview');
    const previewImage = document.getElementById('preview-image');
    const previewVideo = document.getElementById('preview-video');
    const captureBtn = document.getElementById('capture-btn');
    const fileInput = document.getElementById('file_story');
    const galleryBtn = document.getElementById('gallery-btn');
    const flipBtn = document.querySelector('.flip-btn');
    const flashBtn = document.getElementById('flash-btn');
    const cameraContainer = document.getElementById('camera-container');
    const captionContainer = document.getElementById('caption-container');
    const textStoryContainer = document.getElementById('text-story-container');
    const nextBtn = document.getElementById('next-btn');
    const retakeBtn = document.getElementById('retake-btn');
    const loadingScreen = document.getElementById('loading-screen');
    const textStoryBtn = document.getElementById('text-story-btn');
    const textStoryInput = document.getElementById('text-story-input');
    const previewText = document.getElementById('preview-text');
    const textStorySubmit = document.getElementById('text-story-submit');
    const mediaMode = document.getElementById('media-mode');
    const textMode = document.getElementById('text-mode');
    const storyTypeInput = document.getElementById('story_type');
    const textBackgroundInput = document.getElementById('text_background');
    const textFontInput = document.getElementById('text_font');
    const textBackgrounds = document.querySelectorAll('.text-background');
    const fontStyles = document.querySelectorAll('.font-style');
    const storyForm = document.getElementById('story-form');

    // Camera stream
    let stream;
    let facingMode = 'environment'; // Default to rear camera
    let canvas = document.createElement('canvas');
    let capturedImage = null;
    let currentMode = 'media'; // Default mode

    // Initialize camera on page load
    window.addEventListener('DOMContentLoaded', () => {
        initCamera();
        setupTextStoryFeatures();
    });

    // Setup text story features
    function setupTextStoryFeatures() {
        // Real-time preview of text input
        textStoryInput.addEventListener('input', () => {
            previewText.textContent = textStoryInput.value || "Type your text above to preview";
        });

        // Background color selection
        textBackgrounds.forEach(bg => {
            bg.addEventListener('click', () => {
                // Update active state
                textBackgrounds.forEach(el => el.classList.remove('active'));
                bg.classList.add('active');

                // Update preview and hidden input
                const color = bg.getAttribute('data-color');
                document.querySelector('.text-preview').style.backgroundColor = color;
                textBackgroundInput.value = color;
            });
        });

        // Font style selection
        fontStyles.forEach(font => {
            font.addEventListener('click', () => {
                // Update active state
                fontStyles.forEach(el => el.classList.remove('active'));
                font.classList.add('active');

                // Update preview and hidden input
                const fontFamily = font.getAttribute('data-font');
                previewText.style.fontFamily = fontFamily;
                textFontInput.value = fontFamily;
            });
        });

        // Text story submit
        textStorySubmit.addEventListener('click', () => {
            if (!textStoryInput.value.trim()) {
                alert('Please enter some text for your story');
                return;
            }

            // Convert text to image
            convertTextToImage();
        });
    }

    // Convert text to image using canvas
    function convertTextToImage() {
        // Show loading
        loadingScreen.style.display = 'flex';

        // Get current styles
        const backgroundColor = textBackgroundInput.value;
        const fontFamily = textFontInput.value;
        const text = textStoryInput.value;

        // Create canvas for text-to-image conversion
        const textCanvas = document.createElement('canvas');
        textCanvas.width = 1080; // Standard story dimension
        textCanvas.height = 1920;

        const ctx = textCanvas.getContext('2d');

        // Draw background
        ctx.fillStyle = backgroundColor;
        ctx.fillRect(0, 0, textCanvas.width, textCanvas.height);

        // Configure text style
        ctx.fillStyle = 'white';
        ctx.font = `bold 60px ${fontFamily}`;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';

        // Handle multiline text
        const maxWidth = textCanvas.width - 100;
        const lineHeight = 80;
        const words = text.split(' ');
        let line = '';
        let lines = [];

        for (let i = 0; i < words.length; i++) {
            const testLine = line + words[i] + ' ';
            const metrics = ctx.measureText(testLine);

            if (metrics.width > maxWidth && i > 0) {
                lines.push(line);
                line = words[i] + ' ';
            } else {
                line = testLine;
            }
        }
        lines.push(line); // Push the last line

        // Draw text (centered vertically)
        const startY = (textCanvas.height - (lines.length * lineHeight)) / 2;
        lines.forEach((line, index) => {
            ctx.fillText(line, textCanvas.width / 2, startY + (index * lineHeight));
        });

        // Convert to blob/file
        textCanvas.toBlob(blob => {
            const fileName = generateFilename('jpg');
            const file = new File([blob], fileName, {
                type: 'image/jpeg'
            });

            // Set file input
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;

            // Set caption as the text content
            // document.getElementById('caption').value = text;
            document.getElementById('caption').value = '';

            // Hide loading
            loadingScreen.style.display = 'none';

            // Submit the form
            storyForm.submit();
        }, 'image/jpeg', 0.9);
    }

    // Mode switching
    mediaMode.addEventListener('click', () => {
        switchMode('media');
    });

    textMode.addEventListener('click', () => {
        switchMode('text');
    });

    textStoryBtn.addEventListener('click', () => {
        switchMode('text');
    });

    function switchMode(mode) {
        currentMode = mode;
        storyTypeInput.value = mode;

        // Update UI
        if (mode === 'media') {
            mediaMode.classList.add('active');
            textMode.classList.remove('active');
            cameraContainer.style.display = 'flex';
            textStoryContainer.style.display = 'none';
            captionContainer.style.display = 'none';

            // Reinitialize camera if needed
            if (!stream) {
                initCamera();
            }
        } else {
            mediaMode.classList.remove('active');
            textMode.classList.add('active');
            cameraContainer.style.display = 'none';
            textStoryContainer.style.display = 'block';
            captionContainer.style.display = 'none';

            // Stop camera stream to save resources
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        }
    }

    // Generate filename with date format
    function generateFilename(extension) {
        const now = new Date();
        const datePart = now.toISOString().replace(/[-:]/g, '').replace('T', '_').split('.')[0];
        return `story_${datePart}.${extension}`;
    }

    // Initialize camera
    function initCamera() {
        const constraints = {
            video: {
                facingMode: facingMode,
                width: {
                    ideal: 1280
                }, // Higher quality
                height: {
                    ideal: 720
                }, // Higher quality
                frameRate: {
                    ideal: 30
                } // Better frame rate
            },
            audio: false
        };

        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }

        navigator.mediaDevices.getUserMedia(constraints)
            .then(mediaStream => {
                stream = mediaStream;
                cameraPreview.srcObject = stream;

                // Reset UI for camera mode
                resetToCameraMode();
            })
            .catch(error => {
                console.error('Error accessing camera:', error);
                alert('Could not access camera. Please allow camera access or upload from gallery.');
            });
    }

    // Reset UI to camera mode
    function resetToCameraMode() {
        previewImage.style.display = 'none';
        previewVideo.style.display = 'none';
        cameraPreview.style.display = 'block';

        // Button visibility
        captureBtn.style.display = 'flex';
        galleryBtn.style.display = 'flex';
        nextBtn.style.display = 'none';
        retakeBtn.style.display = 'none';
        textStoryBtn.style.display = 'flex';
    }

    // Switch to preview mode after capture
    function switchToPreviewMode() {
        // Show the captured content
        if (previewImage.src) {
            previewImage.style.display = 'block';
            previewVideo.style.display = 'none';
        } else if (previewVideo.src) {
            previewVideo.style.display = 'block';
            previewImage.style.display = 'none';
        }

        // Hide camera preview
        cameraPreview.style.display = 'none';

        // Update buttons
        galleryBtn.style.display = 'none';
        nextBtn.style.display = 'flex';
        retakeBtn.style.display = 'flex';
        textStoryBtn.style.display = 'none';
    }

    // Capture button click
    captureBtn.addEventListener('click', () => {
        capturePhoto();
    });

    // Capture photo with improved quality
    function capturePhoto() {
        // Create high-quality capture from video stream
        canvas.width = cameraPreview.videoWidth;
        canvas.height = cameraPreview.videoHeight;
        let context = canvas.getContext('2d');
        context.drawImage(cameraPreview, 0, 0, canvas.width, canvas.height);

        // Display captured image
        capturedImage = canvas.toDataURL('image/jpeg', 0.9); // Higher quality initial capture

        // Show loading screen
        loadingScreen.style.display = 'flex';

        // Compress the image with improved balance for quality
        canvas.toBlob(blob => {
            new Compressor(blob, {
                quality: 0.8, // Higher quality (maintain good quality)
                maxWidth: 1280, // Higher resolution
                maxHeight: 720, // Higher resolution
                success(compressedBlob) {
                    // Hide loading screen
                    loadingScreen.style.display = 'none';

                    // Convert compressed blob to data URL for preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        switchToPreviewMode();
                    };
                    reader.readAsDataURL(compressedBlob);

                    // Create a File from the compressed Blob with date-based name
                    const fileName = generateFilename('jpg');
                    const compressedFile = new File([compressedBlob], fileName, {
                        type: "image/jpeg"
                    });

                    console.log(`Image captured: ${fileName}, Size: ${Math.round(compressedBlob.size/1024)} KB`);

                    // Create a FileList-like object
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(compressedFile);
                    fileInput.files = dataTransfer.files;
                },
                error(err) {
                    console.error('Compression error:', err);
                    loadingScreen.style.display = 'none';
                    alert('Error compressing image. Using original image.');

                    // Use original image if compression fails
                    previewImage.src = capturedImage;
                    switchToPreviewMode();

                    // Convert data URL to Blob
                    fetch(capturedImage)
                        .then(res => res.blob())
                        .then(blob => {
                            const fileName = generateFilename('jpg');
                            const file = new File([blob], fileName, {
                                type: "image/jpeg"
                            });
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            fileInput.files = dataTransfer.files;
                        });
                }
            });
        }, 'image/jpeg', 0.9); // Higher quality for toBlob
    }

    // Gallery button - trigger file input
    galleryBtn.addEventListener('click', () => {
        fileInput.click();
    });

    // Preview selected file
    fileInput.addEventListener('change', (e) => {
        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            const reader = new FileReader();

            // Show loading screen for images (for compression)
            if (file.type.startsWith('image/')) {
                loadingScreen.style.display = 'flex';
            }

            reader.onload = function(event) {
                if (file.type.startsWith('image/')) {
                    // For images, compress then preview
                    const img = new Image();
                    img.onload = function() {
                        new Compressor(file, {
                            quality: 0.8, // Higher quality
                            maxWidth: 1280, // Higher resolution
                            maxHeight: 720, // Higher resolution
                            success(compressedBlob) {
                                loadingScreen.style.display = 'none';

                                // Generate new filename with date
                                const fileName = generateFilename('jpg');

                                // Create a new compressed file
                                const compressedFile = new File([compressedBlob], fileName, {
                                    type: file.type
                                });

                                console.log(`Gallery image: ${fileName}, Size: ${Math.round(compressedBlob.size/1024)} KB`);

                                // Create a FileList with the compressed file
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(compressedFile);
                                fileInput.files = dataTransfer.files;

                                // Preview compressed image
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    previewImage.src = e.target.result;
                                    switchToPreviewMode();
                                };
                                reader.readAsDataURL(compressedBlob);
                            },
                            error(err) {
                                console.error('Compression error:', err);
                                loadingScreen.style.display = 'none';

                                // Use original image if compression fails
                                previewImage.src = event.target.result;
                                switchToPreviewMode();
                            }
                        });
                    };
                    img.src = event.target.result;
                } else if (file.type.startsWith('video/')) {
                    // For videos, just preview
                    previewVideo.src = event.target.result;
                    switchToPreviewMode();
                }
            };

            reader.readAsDataURL(file);
        }
    });

    // Retake button - go back to camera mode
    retakeBtn.addEventListener('click', () => {
        // Clear previous image/video
        previewImage.src = '';
        previewVideo.src = '';

        // Reset to camera mode
        resetToCameraMode();
    });

    // Next button to go to caption
    nextBtn.addEventListener('click', () => {
        cameraContainer.style.display = 'none';
        captionContainer.style.display = 'block';
    });

    // Switch camera
    flipBtn.addEventListener('click', () => {
        facingMode = facingMode === 'user' ? 'environment' : 'user';
        initCamera();
    });

    // Flash toggle (only works on rear camera and depends on browser support)
    flashBtn.addEventListener('click', () => {
        if (!stream) return;

        const videoTrack = stream.getVideoTracks()[0];
        if (videoTrack && videoTrack.getCapabilities && videoTrack.getCapabilities().torch) {
            const torchOn = !videoTrack.getConstraints().advanced ||
                !videoTrack.getConstraints().advanced.some(c => c.torch === true);

            videoTrack.applyConstraints({
                    advanced: [{
                        torch: torchOn
                    }]
                })
                .then(() => {
                    flashBtn.innerHTML = torchOn ?
                        '<i class="fas fa-bolt" style="color: yellow;"></i>' :
                        '<i class="fas fa-bolt"></i>';
                })
                .catch(err => console.error('Flash not supported:', err));
        } else {
            console.log('Torch feature not available');
        }
    });

    // Clean up resources when leaving page
    window.addEventListener('beforeunload', () => {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('btnCheckAbsen').style.visibility = 'hidden';
    });
</script>