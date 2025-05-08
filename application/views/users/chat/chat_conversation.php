<?php
$id_user = $user->row()->id_user;
?>
<style>
    .container {
        width: 100%;
        margin: 0 auto;
        padding: 0;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .chat-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 15px;
        height: calc(100vh - 30px);
    }

    /* Chat Header */
    .chat-header {
        padding: 12px 16px;
        background-color: #ffffff;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .back-button {
        margin-right: 15px;
        color: #ff3333;
        border: none;
        background: none;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        transition: background-color 0.2s;
    }

    .back-button:hover {
        background-color: #f0f2f5;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .user-avatar-placeholder {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #ff3333;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .user-info {
        flex: 1;
    }

    .user-name {
        font-weight: 600;
        font-size: 16px;
        margin: 0;
        color: #262626;
    }

    .user-status {
        font-size: 13px;
        color: #65676b;
        margin: 0;
    }

    .header-actions .btn {
        background: none;
        border: none;
        color: #ff3333;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .header-actions .btn:hover {
        background-color: #f0f2f5;
    }

    /* Chat Messages Area */
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background-color: #e5ddd5;

    }

    /* Date Divider */
    .date-divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }

    .date-badge {
        padding: 8px 12px;
        background-color: rgba(225, 245, 254, 0.9);
        border-radius: 16px;
        font-size: 12px;
        color: #ff3333;
        font-weight: 500;
        display: inline-block;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    /* Message Styles */
    .message-wrapper {
        margin-bottom: 12px;
        animation: fadeIn 0.3s ease-out;
        position: relative;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message {
        max-width: 75%;
        border-radius: 16px;
        padding: 2px;
        position: relative;
    }

    .message-self {
        float: right;
        background-color: #dcf8c6;
        border-radius: 16px 2px 16px 16px;
        margin-right: 5px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .message-other {
        float: left;
        background-color: #ffffff;
        border-radius: 2px 16px 16px 16px;
        margin-left: 5px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .message-sender {
        font-size: 13px;
        font-weight: 600;
        margin-top: 4px;
        margin-left: 12px;
        color: #ff3333;
    }

    .message-content {
        padding: 8px 12px;
        border-radius: inherit;
        word-wrap: break-word;
        font-size: 15px;
        line-height: 1.4;
    }

    .message-time {
        font-size: 11px;
        color: #8696a0;
        margin-top: 2px;
        margin-right: 8px;
        text-align: right;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .message-status-icon {
        margin-left: 4px;
        font-size: 12px;
    }

    /* Attachments */
    .message-attachment {
        max-width: 100%;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .message-attachment img {
        max-width: 100%;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .message-attachment img:hover {
        transform: scale(1.02);
    }

    .attachment-download {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        background-color: #f0f2f5;
        border-radius: 16px;
        color: #1877f2;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.2s;
    }

    .attachment-download:hover {
        background-color: #e4e6eb;
        text-decoration: none;
    }

    .attachment-download i {
        margin-right: 6px;
    }

    /* Chat Input Area */
    .chat-input {
        padding: 12px 16px;
        background-color: #f0f2f5;
        border-top: 1px solid #e0e0e0;
    }

    .input-container {
        display: flex;
        align-items: flex-end;
        background-color: #fff;
        border-radius: 24px;
        padding: 8px 12px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .input-action {
        color: #ff3333;
        background: none;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .input-action:hover {
        background-color: #f0f2f5;
    }

    #messageInput {
        flex: 1;
        border: none;
        background: none;
        padding: 9px 12px;
        max-height: 100px;
        resize: none;
        font-size: 15px;
        line-height: 1.4;
    }

    #messageInput:focus {
        outline: none;
    }

    .send-button {
        background-color: #ff3333;
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .send-button:hover {
        background-color: #075E54;
    }

    .send-button:disabled {
        background-color: #E0E0E0;
        color: #A0A0A0;
        cursor: not-allowed;
    }

    #selectedFile {
        background-color: #e1f5fe;
        padding: 6px 12px;
        border-radius: 16px;
        margin-top: 8px;
        font-size: 13px;
        display: flex;
        align-items: center;
        color: #ff3333;
    }

    #selectedFile i {
        margin-right: 6px;
    }

    /* Message Options */
    .message-options {
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s, opacity 0.2s;
    }

    .message:hover .message-options {
        visibility: visible;
        opacity: 1;
    }

    .message-dropdown-toggle {
        background: none;
        border: none;
        color: #8696a0;
        padding: 0;
        cursor: pointer;
    }

    /* Clear Floats */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Search Modal */
    .search-modal .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    .search-modal .modal-header {
        background-color: #ff3333;
        color: white;
        border-bottom: none;
    }

    .search-modal .modal-title {
        font-weight: 600;
    }

    .search-modal .close {
        color: white;
        opacity: 0.8;
    }

    .search-input {
        border-radius: 24px;
        padding: 10px 20px;
        border: 1px solid #e0e0e0;
    }

    .search-result {
        border-radius: 8px;
        margin-bottom: 8px;
        transition: background-color 0.2s;
    }

    .search-result:hover {
        background-color: #f5f5f5;
    }

    .search-highlight {
        background-color: #fff9c4;
        padding: 2px 0;
        border-radius: 3px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .chat-container {
            margin: 0;
            height: 100vh;
            border-radius: 0;
        }

        .message {
            max-width: 90%;
        }
    }
</style>

<div class="container">
    <div class="chat-container">
        <!-- Chat header -->
        <div class="chat-header">
            <a href="<?php echo site_url('users/chat_data'); ?>" class="back-button">
                <i class="fa fa-arrow-left"></i>
            </a>

            <?php if (!empty($other_user->foto_profile)) : ?>
                <img src="<?php echo base_url('foto/foto_profile/' . $other_user->foto_profile); ?>" class="user-avatar" alt="<?php echo $other_user->nama_lengkap; ?>">
            <?php else : ?>
                <div class="user-avatar-placeholder">
                    <i class="fa fa-user"></i>
                </div>
            <?php endif; ?>

            <div class="user-info">
                <h5 class="user-name"><?php echo $other_user->nama_lengkap; ?></h5>
                <?php if (!empty($other_user->status)) : ?>
                    <p class="user-status"><?php echo $other_user->status; ?></p>
                <?php else : ?>
                    <p class="user-status">Online</p>
                <?php endif; ?>
            </div>

            <div class="header-actions ml-auto" style="display: flex; align-items: center;">
                <button class="btn" data-toggle="modal" data-target="#searchMessagesModal">
                    <i class="fa fa-search"></i>
                </button>
                <div class="dropdown d-inline-block">
                    <button class="btn" type="button" id="chatOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="chatOptionsDropdown">
                        <a class="dropdown-item" href="#" id="clearChat">
                            <i class="fa fa-trash mr-2"></i> Clear chat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat messages area -->
        <div class="chat-messages" id="chatMessages">
            <?php
            // Reverse messages to show oldest first
            $messages = array_reverse($messages);

            $prev_date = '';
            foreach ($messages as $msg) :
                // Format message date
                $msg_date = date('Y-m-d', strtotime($msg->created_at));
                $is_today = $msg_date == date('Y-m-d');
                $is_yesterday = $msg_date == date('Y-m-d', strtotime('-1 day'));

                if ($prev_date != $msg_date) :
                    $date_display = $is_today ? 'Today' : ($is_yesterday ? 'Yesterday' : date('F d, Y', strtotime($msg->created_at)));
                    $prev_date = $msg_date;
            ?>
                    <div class="date-divider">
                        <span class="date-badge"><?php echo $date_display; ?></span>
                    </div>
                <?php endif; ?>

                <!-- Determine if message is from current user -->
                <?php $is_self = ($msg->id_user == $id_user); ?>

                <div class="message-wrapper clearfix" data-message-id="<?php echo $msg->id; ?>">
                    <div class="message <?php echo $is_self ? 'message-self' : 'message-other'; ?>">
                        <?php if (!$is_self) : ?>
                            <div class="message-sender">
                                <?php echo $msg->sender_name; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($msg->attachment)) : ?>
                            <div class="message-attachment">
                                <?php
                                $file_ext = pathinfo($msg->attachment, PATHINFO_EXTENSION);
                                $image_exts = ['jpg', 'jpeg', 'png', 'gif'];

                                if (in_array(strtolower($file_ext), $image_exts)) :
                                ?>
                                    <a href="<?php echo base_url('files/chat_attachments/' . $msg->attachment); ?>" target="_blank" class="image-link">
                                        <img src="<?php echo base_url('files/chat_attachments/' . $msg->attachment); ?>" alt="Attachment">
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo base_url('files/chat_attachments/' . $msg->attachment); ?>" class="attachment-download" target="_blank">
                                        <i class="fa fa-file"></i> Download File
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="message-content">
                            <?php echo nl2br(htmlspecialchars($msg->message)); ?>
                        </div>

                        <div class="message-time">
                            <?php echo date('h:i A', strtotime($msg->created_at)); ?>
                            <?php if ($is_self) : ?>
                                <?php if ($msg->is_read) : ?>
                                    <i class="fa fa-check-double message-status-icon" title="Read"></i>
                                <?php else : ?>
                                    <i class="fa fa-check message-status-icon" title="Sent"></i>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($is_self) : ?>
                                <div class="dropdown d-inline-block message-options">
                                    <button class="message-dropdown-toggle" type="button" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item delete-message" href="#" data-id="<?php echo $msg->id; ?>">
                                            <i class="fa fa-trash mr-2"></i> Delete
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fa fa-reply mr-2"></i> Reply
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="fa fa-forward mr-2"></i> Forward
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Chat input area -->
        <div class="chat-input">
            <form id="chatForm" enctype="multipart/form-data">
                <input type="hidden" name="receiver_id" value="<?php echo $other_user->id_user; ?>">

                <div class="input-container">
                    <label for="attachment" class="input-action" id="attachmentButton">
                        <i class="fa fa-paperclip"></i>
                        <input type="file" name="attachment" id="attachment" style="display: none;">
                    </label>

                    <textarea class="form-control" name="message" id="messageInput" placeholder="Type a message..." rows="1"></textarea>

                    <button class="send-button" type="submit" id="sendButton" disabled>
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>

                <div id="selectedFile" style="display: none;">
                    <i class="fa fa-file"></i>
                    <span id="selectedFileName"></span>
                    <button type="button" class="close ml-2" id="removeAttachment">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Search Messages Modal -->
<div class="modal fade search-modal" id="searchMessagesModal" tabindex="-1" role="dialog" aria-labelledby="searchMessagesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchMessagesModalLabel">Search in Conversation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" id="conversationSearch" class="form-control search-input" placeholder="Type to search...">
                </div>
                <div id="searchResults" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Image Viewer Modal -->
<div class="modal fade" id="imageViewerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img id="modalImage" src="" class="img-fluid" alt="Full size image">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="downloadImageLink" href="#" class="btn btn-primary" download>Download</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Auto-scroll to bottom of chat
        var chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Enable/disable send button based on input
        function updateSendButton() {
            var messageText = $('#messageInput').val().trim();
            var fileInput = $('#attachment')[0];

            if (messageText !== '' || fileInput.files.length > 0) {
                $('#sendButton').prop('disabled', false);
            } else {
                $('#sendButton').prop('disabled', true);
            }
        }

        // Attachment file selection
        $('#attachmentButton').click(function(e) {
            e.preventDefault();
            $('#attachment').click();
        });

        // Make sure the click doesn't bubble up to parent elements
        $('#attachment').click(function(e) {
            e.stopPropagation();
        });

        $('#attachment').change(function() {
            if (this.files.length > 0) {
                var fileName = this.files[0].name;
                var maxLength = 20;

                if (fileName.length > maxLength) {
                    var extension = fileName.split('.').pop();
                    fileName = fileName.substring(0, maxLength - extension.length - 3) + '...' + extension;
                }

                $('#selectedFileName').text(fileName);
                $('#selectedFile').fadeIn(300);
                updateSendButton();
            } else {
                $('#selectedFile').hide();
                updateSendButton();
            }
        });

        // Remove attachment
        $('#removeAttachment').click(function() {
            $('#attachment').val('');
            $('#selectedFile').fadeOut(300);
            updateSendButton();
        });

        // Auto-resize text area
        $('#messageInput').on('input', function() {
            this.style.height = 'auto';
            this.style.height = (Math.min(this.scrollHeight, 100)) + 'px';
            updateSendButton();
        });

        // Image viewer modal
        $(document).on('click', '.image-link', function(e) {
            e.preventDefault();
            var imgSrc = $(this).attr('href');
            Swal.fire({
                imageUrl: imgSrc,
                imageAlt: 'Chat Image',
                showCloseButton: true,
                showConfirmButton: false,
                background: '#f0f2f5',
                width: '90%',
                padding: '0',
                backdrop: 'rgba(0, 0, 0, 0.8)'
            });
        });

        // Send message via Ajax
        $('#chatForm').submit(function(e) {
            e.preventDefault();

            var messageText = $('#messageInput').val().trim();
            var fileInput = $('#attachment')[0];

            if (messageText === '' && fileInput.files.length === 0) {
                return false;
            }

            var formData = new FormData(this);

            // Show temporary message
            var tempId = 'temp_' + new Date().getTime();
            var tempHtml = `
      <div class="message-wrapper clearfix" id="${tempId}">
        <div class="message message-self">
          <div class="message-content">
            ${messageText}
          </div>
          <div class="message-time">
            <span>Sending...</span>
            <i class="fa fa-clock message-status-icon"></i>
          </div>
        </div>
      </div>
    `;
            $('#chatMessages').append(tempHtml);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // Clear input
            $('#messageInput').val('').css('height', 'auto');
            $('#attachment').val('');
            $('#selectedFile').hide();
            $('#sendButton').prop('disabled', true);

            // Send Ajax request
            $.ajax({
                url: '<?php echo site_url('users/chat_send'); ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    // Remove temp message
                    $('#' + tempId).remove();

                    if (response.status) {
                        // Format the time
                        var date = new Date(response.message.created_at);
                        var hours = date.getHours();
                        var minutes = date.getMinutes();
                        var ampm = hours >= 12 ? 'PM' : 'AM';
                        hours = hours % 12;
                        hours = hours ? hours : 12;
                        minutes = minutes < 10 ? '0' + minutes : minutes;
                        var timeString = hours + ':' + minutes + ' ' + ampm;

                        // Build message HTML
                        var attachmentHtml = '';
                        if (response.message.attachment) {
                            var fileExt = response.message.attachment.split('.').pop().toLowerCase();
                            var imageExts = ['jpg', 'jpeg', 'png', 'gif'];

                            if (imageExts.includes(fileExt)) {
                                attachmentHtml = `
                <div class="message-attachment">
                  <a href="<?php echo base_url('files/chat_attachments/'); ?>${response.message.attachment}" class="image-link" target="_blank">
                    <img src="<?php echo base_url('files/chat_attachments/'); ?>${response.message.attachment}" alt="Attachment">
                  </a>
                </div>
              `;
                            } else {
                                attachmentHtml = `
                <div class="message-attachment">
                  <a href="<?php echo base_url('files/chat_attachments/'); ?>${response.message.attachment}" 
                     class="attachment-download" target="_blank">
                    <i class="fa fa-file"></i> Download File
                  </a>
                </div>
              `;
                            }
                        }

                        var messageHtml = `
            <div class="message-wrapper clearfix" data-message-id="${response.message.id}">
              <div class="message message-self">
                ${attachmentHtml}
                <div class="message-content">
                  ${response.message.message.replace(/\n/g, '<br>')}
                </div>
                <div class="message-time">
                  ${timeString}
                  <i class="fa fa-check message-status-icon" title="Sent"></i>
                  
                  <div class="dropdown d-inline-block message-options">
                    <button class="message-dropdown-toggle" type="button" data-toggle="dropdown">
                      <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item delete-message" href="#" data-id="${response.message.id}">
                        <i class="fa fa-trash mr-2"></i> Delete
                      </a>
                      <a class="dropdown-item" href="#">
                        <i class="fa fa-reply mr-2"></i> Reply
                      </a>
                      <a class="dropdown-item" href="#">
                        <i class="fa fa-forward mr-2"></i> Forward
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `;

                        $('#chatMessages').append(messageHtml);
                        chatMessages.scrollTop = chatMessages.scrollHeight;

                        // Play send sound if available
                        // var sendSound = new Audio('path/to/send_sound.mp3');
                        // sendSound.play();
                    } else {
                        // Show error message
                        toastr.error(response.msg || 'Failed to send message');
                    }
                },
                error: function() {
                    // Remove temp message
                    $('#' + tempId).remove();

                    // Show error
                    toastr.error('Network error. Please try again.');
                }
            });
        });

        // Delete message
        // Delete message
        $(document).on('click', '.delete-message', function(e) {
            e.preventDefault();

            var messageId = $(this).data('id');
            var messageWrapper = $(this).closest('.message-wrapper');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo site_url('users/chat_delete'); ?>',
                        type: 'POST',
                        data: {
                            message_id: messageId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                messageWrapper.fadeOut(300, function() {
                                    $(this).remove();
                                });
                                Swal.fire('Deleted!', 'Your message has been deleted.', 'success');
                            } else {
                                Swal.fire('Error', response.msg, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed to delete message. Please try again.', 'error');
                        }
                    });
                }
            });
        });

        // Clear chat
        $('#clearChat').click(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Get the other user ID from the URL or a data attribute
                    var otherUserId = <?php echo $other_user->id_user; ?>;

                    $.ajax({
                        url: '<?php echo site_url('users/chat_clear'); ?>',
                        type: 'POST',
                        data: {
                            other_user_id: otherUserId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                // Clear all messages from the UI
                                // $('#messagesList').empty();
                                // Or you could reload the page
                                location.reload();
                            } else {
                                Swal.fire('Error', response.msg, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed to clear chat. Please try again.', 'error');
                        }
                    });
                }
            });
        });

        // Search in conversation
        $('#conversationSearch').on('input', function() {
            var keyword = $(this).val().trim();
            var resultsContainer = $('#searchResults');

            if (keyword.length < 2) {
                resultsContainer.html('');
                return;
            }

            // Search in the current conversation
            var matches = [];
            $('.message-content').each(function() {
                var messageText = $(this).text();
                var messageId = $(this).closest('.message-wrapper').data('message-id');

                if (messageText.toLowerCase().includes(keyword.toLowerCase())) {
                    var sender = $(this).closest('.message-wrapper').find('.message-sender').text().trim();
                    if (!sender) {
                        sender = 'You';
                    }

                    matches.push({
                        id: messageId,
                        text: messageText,
                        sender: sender
                    });
                }
            });

            // Display results
            if (matches.length > 0) {
                var resultsHtml = '<div class="list-group">';
                matches.forEach(function(match) {
                    // Get the context around the match
                    var index = match.text.toLowerCase().indexOf(keyword.toLowerCase());
                    var start = Math.max(0, index - 20);
                    var end = Math.min(match.text.length, index + keyword.length + 20);
                    var snippet = match.text.substring(start, end);

                    // Highlight the keyword
                    var highlightedSnippet = snippet.replace(
                        new RegExp(keyword, 'gi'),
                        '<span class="bg-warning">$&</span>'
                    );

                    resultsHtml += `
                    <a href="#" class="list-group-item list-group-item-action search-result" data-message-id="${match.id}">
                        <div class="small text-muted">${match.sender}</div>
                        <div>...${highlightedSnippet}...</div>
                    </a>
                `;
                });
                resultsHtml += '</div>';
                resultsContainer.html(resultsHtml);
            } else {
                resultsContainer.html('<div class="alert alert-info">No messages found.</div>');
            }
        });

        // Click on search result
        $(document).on('click', '.search-result', function(e) {
            e.preventDefault();

            var messageId = $(this).data('message-id');
            var messageElement = $('[data-message-id="' + messageId + '"]');

            if (messageElement.length) {
                // Highlight the message briefly
                messageElement.find('.message-content').addClass('bg-warning');

                // Scroll to the message
                chatMessages.scrollTop = messageElement.offset().top - chatMessages.offsetTop - 50;

                // Hide the modal
                $('#searchMessagesModal').modal('hide');

                // Remove highlight after a moment
                setTimeout(function() {
                    messageElement.find('.message-content').removeClass('bg-warning');
                }, 2000);
            }
        });

        // Poll for new messages
        var lastMessageTime = <?php echo !empty($messages) ? "'" . end($messages)->created_at . "'" : 'null'; ?>;

        function checkNewMessages() {
            $.ajax({
                url: '<?php echo site_url('users/check_new_messages'); ?>',
                type: 'POST',
                data: {
                    last_message_time: lastMessageTime,
                    other_user_id: <?php echo $other_user->id_user; ?>
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status && response.new_messages && response.new_messages.length > 0) {
                        var newMessagesHtml = '';
                        var lastVisible = false;

                        $.each(response.new_messages, function(index, msg) {
                            // Format the time
                            var date = new Date(msg.created_at);
                            var hours = date.getHours();
                            var minutes = date.getMinutes();
                            var ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12;
                            hours = hours ? hours : 12;
                            minutes = minutes < 10 ? '0' + minutes : minutes;
                            var timeString = hours + ':' + minutes + ' ' + ampm;

                            // Check if we need to add a date header
                            var msgDate = new Date(msg.created_at).toLocaleDateString();
                            var today = new Date().toLocaleDateString();
                            var yesterday = new Date();
                            yesterday.setDate(yesterday.getDate() - 1);
                            yesterday = yesterday.toLocaleDateString();

                            var dateDisplay = msgDate === today ? 'Today' :
                                (msgDate === yesterday ? 'Yesterday' :
                                    new Date(msg.created_at).toLocaleDateString('en-US', {
                                        month: 'long',
                                        day: 'numeric',
                                        year: 'numeric'
                                    }));

                            var prevMsgDate = lastMessageTime ? new Date(lastMessageTime).toLocaleDateString() : null;

                            if (prevMsgDate !== msgDate) {
                                newMessagesHtml += `
                                <div class="text-center my-3">
                                    <span class="badge badge-pill badge-light">${dateDisplay}</span>
                                </div>
                            `;
                            }

                            // Build attachment HTML if needed
                            var attachmentHtml = '';
                            if (msg.attachment) {
                                var fileExt = msg.attachment.split('.').pop().toLowerCase();
                                var imageExts = ['jpg', 'jpeg', 'png', 'gif'];

                                if (imageExts.includes(fileExt)) {
                                    attachmentHtml = `
                                    <div class="message-attachment mb-2">
                                        <a href="<?php echo base_url('files/chat_attachments/'); ?>${msg.attachment}" target="_blank">
                                            <img src="<?php echo base_url('files/chat_attachments/'); ?>${msg.attachment}" 
                                                class="img-fluid rounded" style="max-height: 200px;" alt="Attachment">
                                        </a>
                                    </div>
                                `;
                                } else {
                                    attachmentHtml = `
                                    <div class="message-attachment mb-2">
                                        <a href="<?php echo base_url('files/chat_attachments/'); ?>${msg.attachment}" 
                                           class="btn btn-sm btn-light" target="_blank">
                                            <i class="fa fa-file"></i> Download Attachment
                                        </a>
                                    </div>
                                `;
                                }
                            }

                            newMessagesHtml += `
                            <div class="message-wrapper mb-3" data-message-id="${msg.id}">
                                <div class="message message-other" style="display: inline-block; max-width: 70%; text-align: left;">
                                    <div class="message-sender font-weight-bold">
                                        ${msg.sender_name}
                                    </div>
                                    
                                    ${attachmentHtml}
                                    
                                    <div class="message-content p-3 rounded" style="background-color: #f1f0f0; word-wrap: break-word;">
                                        ${msg.message.replace(/\n/g, '<br>')}
                                    </div>
                                    
                                    <div class="message-time small text-muted mt-1">
                                        ${timeString}
                                    </div>
                                </div>
                            </div>
                        `;

                            lastMessageTime = msg.created_at;
                            lastVisible = (index === response.new_messages.length - 1);
                        });

                        // Append new messages
                        $('#chatMessages').append(newMessagesHtml);

                        // Scroll to bottom if user was already at bottom
                        if (chatMessages.scrollTop + chatMessages.clientHeight >= chatMessages.scrollHeight - 100 || lastVisible) {
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        }

                        // Play notification sound if implemented
                        // playNotificationSound();
                    }
                }
            });
        }

        // Check for new messages every 5 seconds
        setInterval(checkNewMessages, 5000);

        // Initial check for new messages
        checkNewMessages();
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('nav').style.visibility = 'hidden';

        // To disable swipe refresh:
        Android.enableSwipeRefresh(false);

        // To enable swipe refresh:
        // Android.enableSwipeRefresh(true);
    });
</script>

<!-- CSS for Chat UI -->
<style>
    .chat-messages {
        background-color: #e5ddd5;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .message-self .message-content {
        border-radius: 15px 0px 15px 15px !important;
    }

    .message-other .message-content {
        border-radius: 0px 15px 15px 15px !important;
    }

    #attachmentButton {
        cursor: pointer;
    }
</style>