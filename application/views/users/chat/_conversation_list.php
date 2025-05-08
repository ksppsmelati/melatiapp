<?php foreach ($conversations as $convo) : ?>
    <?php
    // Determine if this is a message sent by the current user
    $is_sender = ($convo->id_user == $this->session->userdata('id_user@mt'));

    // Determine the other user's ID
    $other_user_id = $is_sender ? $convo->receiver_id : $convo->id_user;

    // Determine if there are unread messages
    $has_unread = (!$is_sender && $convo->is_read == 0);
    ?>

    <a href="<?php echo site_url('users/chat_conversation/' . $other_user_id); ?>" class="list-group-item list-group-item-action conversation-item <?php echo $has_unread ? 'active' : ''; ?>">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <div class="media d-flex align-items-center">
                <?php if (!empty($convo->sender_photo)) : ?>
                    <img src="<?php echo base_url('foto/foto_profile/' . $convo->sender_photo); ?>" class="mr-3 profile-image" alt="Profile" loading="lazy">
                <?php else : ?>
                    <div class="mr-3 profile-placeholder">
                        <i class="fa fa-user"></i>
                    </div>
                <?php endif; ?>

                <div class="media-body conversation-details">
                    <h5>
                        <?php echo $is_sender ? 'You → ' . $convo->sender_name : $convo->sender_name; ?>
                        <?php if ($has_unread) : ?>
                            <span class="badge badge-danger new-badge">New</span>
                        <?php endif; ?>
                    </h5>
                    <p class="conversation-message">
                        <?php echo $is_sender ? 'You: ' : ''; ?>
                        <?php
                        if (!empty($convo->attachment)) {
                            echo '<i class="fa fa-paperclip"></i> ';
                        }
                        echo htmlspecialchars($convo->message);
                        ?>
                    </p>
                    <small class="conversation-time">
                        <?php
                        $message_time = new DateTime($convo->created_at);
                        $now = new DateTime();
                        $diff = $message_time->diff($now);

                        if ($diff->y > 0) {
                            echo $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
                        } elseif ($diff->m > 0) {
                            echo $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
                        } elseif ($diff->d > 0) {
                            echo $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
                        } elseif ($diff->h > 0) {
                            echo $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
                        } elseif ($diff->i > 0) {
                            echo $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
                        } else {
                            echo 'Just now';
                        }
                        ?>
                    </small>
                </div>
            </div>
        </div>
    </a>
<?php endforeach; ?>