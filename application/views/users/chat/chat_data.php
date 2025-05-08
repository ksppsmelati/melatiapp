<?php
$cek = $user->row();
$id_user = $cek->id_user;
$nama_lengkap = $cek->nama_lengkap;
?>

<style>
  /* Core container styles */
  .container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
  }

  /* Chat panel core components */
  .chat-panel {
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    background-color: #fff;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .chat-header {
    padding: 15px 20px;
    background: linear-gradient(135deg, #ff0033, #ff9933);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .chat-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
  }

  .chat-title i {
    margin-right: 10px;
  }

  .unread-badge {
    background-color: #ff4757;
    padding: 4px 8px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: bold;
    margin-left: 10px;
    animation: pulse 1.5s infinite;
  }

  @keyframes pulse {
    0% {
      transform: scale(0.95);
    }

    50% {
      transform: scale(1.05);
    }

    100% {
      transform: scale(0.95);
    }
  }

  .chat-body {
    padding: 0;
    max-height: 600px;
    overflow-y: auto;
  }

  /* Search components */
  .search-container {
    padding: 15px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    position: sticky;
    top: 0;
    z-index: 5;
  }

  .search-bar {
    position: relative;
  }

  .search-bar .form-control {
    padding-left: 40px;
    border-radius: 20px;
    height: 45px;
    box-shadow: none;
    border: 1px solid #e1e5eb;
    transition: all 0.3s ease;
  }

  .search-bar .form-control:focus {
    border-color: #ff9933;
    box-shadow: 0 0 0 0.2rem rgba(255, 153, 51, 0.25);
  }

  .search-bar .search-icon {
    position: absolute;
    left: 15px;
    top: 13px;
    color: #6c757d;
  }

  /* Conversation list styles */
  .conversation-list {
    padding: 0;
  }

  .conversation-item {
    border-left: 0;
    border-right: 0;
    border-radius: 0;
    padding: 15px;
    transition: all 0.3s ease;
    border-bottom: 1px solid #f1f1f1;
  }

  .conversation-item:hover {
    background-color: #f8f9fa;
  }

  .conversation-item.active {
    background-color: rgba(255, 153, 51, 0.1);
    border-left: 4px solid #ff9933;
  }

  /* Profile image styles */
  .profile-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .profile-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #6c757d;
    color: white;
    font-size: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  /* Conversation details */
  .conversation-details h5 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
  }

  .conversation-message {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
  }

  .conversation-time {
    font-size: 12px;
    color: #adb5bd;
  }

  .new-badge {
    background-color: #ff4757;
    font-size: 10px;
    font-weight: bold;
    padding: 3px 8px;
    margin-left: 8px;
  }

  /* Empty state styling */
  .empty-state {
    padding: 60px 20px;
    text-align: center;
  }

  .empty-state i {
    font-size: 60px;
    color: #dee2e6;
    margin-bottom: 20px;
  }

  .empty-state p {
    color: #6c757d;
    margin-bottom: 20px;
    font-size: 16px;
  }

  /* Modal styling */
  .modal-search-container {
    position: sticky;
    top: 0;
    background-color: white;
    z-index: 10;
    padding: 15px 15px 5px 15px;
    border-bottom: 1px solid #f1f1f1;
  }

  .user-list-container {
    max-height: 400px;
    overflow-y: auto;
    padding-top: 0;
    scrollbar-width: thin;
  }

  .user-list-container::-webkit-scrollbar {
    width: 6px;
  }

  .user-list-container::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
  }

  .modal-content {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .modal-header {
    background: linear-gradient(135deg, #ff0033, #ff9933);
    color: white;
    padding: 1rem 1.5rem;
    border-bottom: none;
  }

  .modal-title {
    font-weight: 600;
  }

  .modal-body {
    padding: 0;
  }

  #userSearch {
    border-radius: 20px;
    padding: 12px 20px;
    box-shadow: none;
    border: 1px solid #e1e5eb;
    transition: all 0.3s ease;
  }

  #userSearch:focus {
    border-color: #ff9933;
    box-shadow: 0 0 0 0.2rem rgba(255, 153, 51, 0.25);
  }

  /* User list styles */
  .user-list-content {
    display: flex;
    align-items: center;
  }

  .user-list-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 15px;
    object-fit: cover;
  }

  .user-list-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #6c757d;
    color: white;
  }

  .user-list-name {
    margin: 0;
    font-size: 15px;
    font-weight: 500;
  }

  .user-list-item {
    padding: 12px 20px;
    transition: background-color 0.2s ease;
  }

  .user-list-item:hover {
    background-color: #f8f9fa;
  }

  /* Dropdown menu styling */
  .dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: none;
    padding: 10px 0;
  }

  .dropdown-item {
    padding: 10px 20px;
    color: #495057;
    transition: all 0.2s ease;
  }

  .dropdown-item i {
    margin-right: 10px;
    color: #ff0033;
    width: 20px;
    text-align: center;
  }

  .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #ff0033;
  }

  .dropdown-divider {
    margin: 5px 0;
    border-top: 1px solid #f1f1f1;
  }

  /* Button styling */
  .btn-primary {
    background: linear-gradient(135deg, #ff0033, #ff9933);
    border: none;
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    background: linear-gradient(135deg, #e60030, #e68a30);
  }

  /* Floating action button */
  .floating-action-button {
    position: fixed;
    bottom: 100px;
    right: 30px;
    z-index: 1050;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff0033, #ff9933);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .floating-action-button:hover,
  .floating-action-button:focus {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #e60030, #e68a30);
  }

  /* Ripple effect */
  .ripple {
    position: relative;
    overflow: hidden;
  }

  .ripple:after {
    content: "";
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    pointer-events: none;
    background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
    background-repeat: no-repeat;
    background-position: 50%;
    transform: scale(10, 10);
    opacity: 0;
    transition: transform .5s, opacity 1s;
  }

  .ripple:active:after {
    transform: scale(0, 0);
    opacity: .3;
    transition: 0s;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .chat-panel {
      margin: 0 -15px;
    }

    .floating-action-button {
      bottom: 100px;
      right: 20px;
    }

    .conversation-message {
      max-width: 200px;
    }
  }
</style>

<div class="container">
  <div class="content">
    <?php echo $this->session->flashdata('msg'); ?>
    <div class="row">
      <div class="col-12">
        <div class="chat-panel">
          <!-- Chat Header -->
          <div class="chat-header">
            <h2 class="chat-title">
              <i class="fa fa-comments"></i>
              <?php if ($unread_count > 0) : ?>
                <span class="unread-badge"><?php echo $unread_count; ?></span>
              <?php endif; ?>
            </h2>
            <div class="d-flex align-items-center">


              <!-- Actions Dropdown -->
              <div class="dropdown">
                <!-- Actions button -->
                <button class="btn dropdown-toggle ripple" data-toggle="dropdown" style="background-color: rgba(255,255,255,0.2);
        border-radius: 50px;
        padding: 8px 16px;
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        font-size: 16px;
        transition: all 0.3s ease;">
                  <i class="fa fa-plus-circle mr-2" style="font-size: 18px;"></i>
                  <span>Actions</span>
                </button>

                <!-- Refresh Button -->
                <button class="btn ripple mr-2" onclick="window.location.reload()" style="background-color: rgba(255,255,255,0.2);
      border-radius: 50px;
      padding: 8px 16px;
      border: 1px solid rgba(255,255,255,0.3);
      color: white;
      font-size: 16px;
      transition: all 0.3s ease;">
                  <i class="fa fa-sync-alt" style="font-size: 18px;"></i>
                </button>

                <!-- Dropdown menu -->
                <div class="dropdown-menu dropdown-menu-right shadow">
                  <!-- Delete All button -->
                  <a class="dropdown-item d-flex align-items-center" href="#" data-toggle="modal" data-target="#confirmDeleteAllModal">
                    <i class="fa-solid fa-trash-alt"></i>
                    <span>Delete All Chats</span>
                  </a>

                  <div class="dropdown-divider"></div>

                  <!-- All Chats button -->
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo site_url('users/chat_data'); ?>">
                    <i class="fa fa-comments"></i>
                    <span>All Chats</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Chat Body -->
          <div class="chat-body">
            <!-- Search Bar -->
            <div class="search-container">
              <div class="search-bar">
                <span class="search-icon">
                  <i class="fa fa-search"></i>
                </span>
                <input type="text" id="conversationSearch" class="form-control" placeholder="Search messages...">
              </div>
            </div>

            <!-- Conversations List -->
            <div class="conversation-list" id="conversationList">
              <?php $this->load->view('users/chat/_conversation_list'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Floating action button for new chat -->
<button class="floating-action-button" data-toggle="modal" data-target="#newChatModal" title="Start New Chat">
  <i class="fa-solid fa-comment-medical" style="font-size: 24px;"></i>
</button>

<!-- Confirm Delete All Modal -->
<div class="modal fade" id="confirmDeleteAllModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteAllModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteAllModalLabel">Confirm Delete</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete all conversations? This action cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a href="<?php echo site_url('users/delete_all_chats'); ?>" class="btn btn-danger">Delete All</a>
      </div>
    </div>
  </div>
</div>

<!-- New Chat Modal -->
<div class="modal fade" id="newChatModal" tabindex="-1" role="dialog" aria-labelledby="newChatModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newChatModalLabel">
          Start New Chat
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <!-- Fixed search bar container -->
      <div class="modal-search-container">
        <div class="mb-3">
          <div>
            <input type="text" id="userSearch" class="form-control" placeholder="Search users...">
          </div>
        </div>
      </div>

      <!-- Scrollable content area -->
      <div class="modal-body p-0">
        <div class="list-group user-list-container" id="userList">
          <?php foreach ($user_list as $u) : ?>
            <a href="<?php echo site_url('users/chat_conversation/' . $u->id_user); ?>" class="list-group-item list-group-item-action user-list-item">
              <div class="user-list-content">
                <?php if (!empty($u->foto_profile)) : ?>
                  <img src="<?php echo base_url('foto/foto_profile/' . $u->foto_profile); ?>" class="user-list-image" alt="Profile" loading="lazy">
                <?php else : ?>
                  <div class="user-list-placeholder">
                    <i class="fa fa-user"></i>
                  </div>
                <?php endif; ?>
                <span class="user-list-name"><?php echo $u->nama_lengkap; ?></span>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Hide the check attendance button (as per your original requirement)
    const checkAbsenBtn = document.getElementById('btnCheckAbsen');
    if (checkAbsenBtn) {
      checkAbsenBtn.style.visibility = 'hidden';
    }

    // Initialize components with smooth fade-in
    const chatPanel = document.querySelector(".chat-panel");
    if (chatPanel) {
      chatPanel.style.opacity = "0";
      setTimeout(() => {
        chatPanel.style.opacity = "1";
        chatPanel.style.transition = "opacity 0.5s ease";
      }, 100);
    }

    // User search functionality
    const userSearch = document.getElementById("userSearch");
    const userListItems = document.querySelectorAll(".user-list-item");
    const userList = document.getElementById("userList");

    if (userSearch) {
      userSearch.addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase().trim();
        let foundResults = false;

        userListItems.forEach(item => {
          const userName = item.querySelector(".user-list-name").textContent.toLowerCase();
          if (userName.includes(searchTerm)) {
            item.style.display = "block";
            foundResults = true;
          } else {
            item.style.display = "none";
          }
        });

        // Show no results message if needed
        const existingNoResults = document.getElementById("emptyUserSearchResults");

        if (!foundResults) {
          if (!existingNoResults) {
            const noResults = document.createElement("div");
            noResults.id = "emptyUserSearchResults";
            noResults.className = "empty-state";
            noResults.innerHTML = `
            <i class="fa fa-search"></i>
            <p>No users match "${searchTerm}"</p>
          `;
            userList.appendChild(noResults);
          } else {
            existingNoResults.querySelector("p").textContent = `No users match "${searchTerm}"`;
          }
        } else if (existingNoResults) {
          existingNoResults.remove();
        }
      });
    }

    // Conversation search functionality
    const conversationSearch = document.getElementById("conversationSearch");
    const conversationItems = document.querySelectorAll(".conversation-item");
    const conversationList = document.getElementById("conversationList");

    if (conversationSearch) {
      conversationSearch.addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase().trim();
        let foundResults = false;

        const conversationItems = document.querySelectorAll(".conversation-item");

        // If search is empty, show all conversations
        if (searchTerm === "") {
          conversationItems.forEach(item => {
            item.style.display = "block";
          });

          // Remove any "no results" message
          const existingNoResults = document.getElementById("emptySearchResults");
          if (existingNoResults) {
            existingNoResults.remove();
          }
          return;
        }

        // Filter conversations
        conversationItems.forEach(item => {
          const conversationName = item.querySelector(".conversation-details h5").textContent.toLowerCase();
          const messageContent = item.querySelector(".conversation-message").textContent.toLowerCase();

          if (conversationName.includes(searchTerm) || messageContent.includes(searchTerm)) {
            item.style.display = "block";
            foundResults = true;
          } else {
            item.style.display = "none";
          }
        });

        // Show no results message if needed
        const existingNoResults = document.getElementById("emptySearchResults");

        if (!foundResults) {
          if (!existingNoResults) {
            const noResults = document.createElement("div");
            noResults.id = "emptySearchResults";
            noResults.className = "empty-state";
            noResults.innerHTML = `
            <i class="fa fa-search"></i>
            <p>No conversations match "${searchTerm}"</p>
          `;
            conversationList.appendChild(noResults);
          } else {
            existingNoResults.querySelector("p").textContent = `No conversations match "${searchTerm}"`;
          }
        } else if (existingNoResults) {
          existingNoResults.remove();
        }
      });
    }

    // Add hover effects for conversation items
    conversationItems.forEach(item => {
      item.addEventListener("mouseenter", function() {
        this.classList.add("shadow-sm");
      });

      item.addEventListener("mouseleave", function() {
        this.classList.remove("shadow-sm");
      });
    });

    // Add ripple effect to buttons
    const buttons = document.querySelectorAll(".btn");
    buttons.forEach(button => {
      button.classList.add("ripple");
    });

    // Fungsi untuk periksa pesan baru
    function checkNewMessages() {
      $.ajax({
        url: '<?php echo site_url("users/check_new_messages"); ?>',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
          if (response.status && response.unread_count > 0) {
            // Update badge dengan animasi
            var badge = $('.unread-badge');
            if (badge.length) {
              badge.fadeOut(200, function() {
                $(this).text(response.unread_count).fadeIn(200);
              });
            } else {
              $('<span class="unread-badge">')
                .text(response.unread_count)
                .hide()
                .appendTo('.chat-title')
                .fadeIn(300);
            }

            // Suara notifikasi
            var notificationSound = new Audio('<?php echo base_url("assets/sounds/notification.mp3"); ?>');
            notificationSound.play().catch(function(e) {
              // Error silent jika autoplay diblokir
            });

            // Tidak perlu reload halaman
            // Kamu bisa tambahkan trigger atau update konten di sini kalau mau
          }
        },
        error: function(xhr, status, error) {
          console.error("Error checking messages:", error);
        }
      });
    }

    function fetchConversations() {
      fetch("<?= site_url('users/get_conversations_html') ?>")
        .then(response => response.text())
        .then(html => {
          document.getElementById("conversationList").innerHTML = html;

          // Tambahkan ulang efek hover dan ripple
          document.querySelectorAll(".conversation-item").forEach(item => {
            item.addEventListener("mouseenter", function() {
              this.classList.add("shadow-sm");
            });
            item.addEventListener("mouseleave", function() {
              this.classList.remove("shadow-sm");
            });
          });

          document.querySelectorAll(".btn").forEach(button => {
            button.classList.add("ripple");
          });
        })
        .catch(error => console.error("Failed to update conversations:", error));
    }


    // Cek pesan awal dan setiap 10 detik
    checkNewMessages();
    setInterval(checkNewMessages, 10000);
    setInterval(fetchConversations, 5000);
  });
</script>