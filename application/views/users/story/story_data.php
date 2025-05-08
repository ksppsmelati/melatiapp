<?php
$cek = $user->row(); //  mengambil nilai data dari tabel tbl_user 
$id_user = $cek->id_user; //  nilai level dari variabel $level

?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/jquery-ui.js"></script>
<style>
    .story-progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 3px;
        background-color: rgba(255, 255, 255, 0.7);
        width: 0;
        transition: width 0.1s linear;
    }

    .story-progress-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        display: flex;
        gap: 4px;
        padding: 8px;
        z-index: 10;
    }

    .progress-segment {
        flex-grow: 1;
        height: 3px;
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
        overflow: hidden;
    }

    .progress-segment-fill {
        height: 100%;
        width: 0;
        background-color: white;
        transition: width 0.1s linear;
    }

    .viewed-story {
        opacity: 0.6;
    }

    .story-viewed-indicator {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        background-color: green;
        border-radius: 50%;
    }

    .caption-overlay {
        position: absolute;
        bottom: 120px;
        ;
        left: 0;
        right: 0;
        padding: 16px;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        z-index: 10;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        min-height: 60px;
        /* Ensure minimum height for visibility */
        display: flex;
        align-items: center;
    }

    .caption-text {
        font-size: 16px;
        font-weight: 500;
        line-height: 1.4;
        word-wrap: break-word;
        max-height: 100px;
        overflow-y: auto;
        width: 100%;
        text-align: left;
    }

    .story-header {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 10;
        background: linear-gradient(rgba(0, 0, 0, 0.5), transparent);
    }

    .story-actions {
        display: flex;
        gap: 12px;
    }

    .action-button {
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .action-button:hover {
        background-color: rgba(0, 0, 0, 0.6);
    }

    .story-content {
        position: relative;
        max-height: 80vh;
        overflow: hidden;
        background-color: #000;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        background-size: cover;
        background-position: center;
        border: 2px solid white;
        flex-shrink: 0;
    }

    .user-time {
        font-size: 12px;
        opacity: 0.8;
    }

    /* New style for story thumbnail */
    .story-item-thumbnail {
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e53e3e;
    }

    /* Add video thumbnail indicator */
    .video-indicator {
        position: absolute;
        right: -2px;
        bottom: -2px;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
    }
</style>

<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-4 bg-red-500 text-white font-bold text-lg flex justify-between items-center">
            <span>Stories</span>
            <button onclick="window.location.href='<?php echo base_url('users/story_tambah'); ?>'" class="text-white hover:bg-green-600 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>

        <!-- Story List -->
        <div class="p-4">
            <input type="text" id="search-story" placeholder="Search stories..." class="w-full p-2 border rounded-lg mb-4" oninput="filterStories()">
            <div id="story-list" class="space-y-4">
                <?php
                // Ambil current user ID
                $current_user_id = $this->session->userdata('id_user');
                $current_time = date('Y-m-d H:i:s');

                if (!empty($stories)) {
                    // Group stories by user
                    $userStories = [];
                    foreach ($stories as $story) {
                        $userStories[$story['id_user']][] = $story;
                    }

                    foreach ($userStories as $userId => $userStoriesList) {
                        // Sort stories by created_at timestamp to get the latest one first
                        usort($userStoriesList, function ($a, $b) {
                            return strtotime($b['created_at']) - strtotime($a['created_at']);
                        });

                        // Get the most recent story for thumbnail
                        $latestStory = $userStoriesList[0];

                        // Determine thumbnail URL - use story content if available, otherwise use profile photo
                        $thumbnailUrl = '';
                        $isVideo = false;

                        if ($latestStory['type'] === 'image' && file_exists('./stories/' . $latestStory['file_path'])) {
                            $thumbnailUrl = base_url('stories/' . $latestStory['file_path']);
                        } elseif ($latestStory['type'] === 'video' && file_exists('./stories/' . $latestStory['file_path'])) {
                            $thumbnailUrl = base_url('stories/' . $latestStory['file_path']);
                            $isVideo = true;
                        }

                        // Reorder stories in original order for display
                        usort($userStoriesList, function ($a, $b) {
                            return strtotime($a['created_at']) - strtotime($b['created_at']);
                        });

                        $firstStory = $userStoriesList[0];
                        $userQuery = $this->db->get_where('tbl_user', ['id_user' => $userId]);
                        $user = $userQuery->row();

                        // Get user profile photo as fallback
                        $userPhoto = (!empty($user->foto_profile) && file_exists('./foto/foto_profile/' . $user->foto_profile))
                            ? base_url('foto/foto_profile/' . $user->foto_profile)
                            : base_url('foto/default.png');

                        // Use profile photo if no valid story thumbnail
                        if (empty($thumbnailUrl)) {
                            $thumbnailUrl = $userPhoto;
                        }

                        // Cek apakah story sudah dilihat
                        $viewed_by = json_decode($firstStory['viewed_by'] ?? '[]', true);
                        $is_viewed = in_array($current_user_id, $viewed_by);
                ?>
                        <div class="user-stories-group <?= $is_viewed ? 'viewed-story' : ''; ?>" data-user-id="<?= $userId; ?>" data-stories='<?= json_encode($userStoriesList); ?>' data-username='<?= $user ? $user->nama_lengkap : 'Unknown User'; ?>' data-userphoto='<?= $userPhoto; ?>'>
                            <div class="flex items-center bg-gray-100 p-3 rounded-lg shadow-sm cursor-pointer relative">
                                <div class="story-item-thumbnail w-12 h-12 mr-4 rounded-full bg-cover bg-center relative" style="background-image: url('<?= $thumbnailUrl; ?>');">
                                    <?php if ($isVideo) : ?>
                                        <div class="video-indicator">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-grow">
                                    <h3 class="font-bold text-sm">
                                        <?= $user ? $user->nama_lengkap : 'Unknown User'; ?>
                                    </h3>
                                    <p class="text-xs text-gray-600">
                                        <?= count($userStoriesList); ?> stories
                                        <?php if ($firstStory['views_count'] > 0) : ?>
                                            • <?= $firstStory['views_count']; ?> views
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <!-- Tombol Hapus Story -->
                                <?php if ($userId == $current_user_id) : ?>
                                    <button onclick="event.stopPropagation(); deleteAllUserStories(<?= $userId; ?>)" class="ml-4 text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="text-center text-gray-500">No stories available</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    const CURRENT_USER_ID = '<?php echo $this->session->userdata('id_user'); ?>';

    // Global variables to manage story playback
    let currentUserStories = [];
    let currentStoryIndex = 0;
    let storyProgressInterval = null;
    let storyProgressElements = [];
    let currentUsername = '';
    let currentUserId = '';
    let currentUserPhoto = '';

    // Function to show stories for a specific user
    function showUserStories(userStoriesGroup) {
        // Parse stories data
        const storiesData = JSON.parse(userStoriesGroup.dataset.stories || '[]');
        currentUserStories = storiesData;
        currentStoryIndex = 0;
        currentUsername = userStoriesGroup.dataset.username;
        currentUserId = userStoriesGroup.dataset.userId;
        currentUserPhoto = userStoriesGroup.dataset.userphoto;

        // Create progress segments
        storyProgressElements = [];
        for (let i = 0; i < currentUserStories.length; i++) {
            storyProgressElements.push({
                viewed: false,
                element: null
            });
        }

        // Play the first story
        playCurrentStory();
    }

    // Function to format timestamp
    function formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);

        if (date.toDateString() === today.toDateString()) {
            return 'Today at ' + date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        } else if (date.toDateString() === yesterday.toDateString()) {
            return 'Yesterday at ' + date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        } else {
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }

    // Function to play the current story
    // Add this to your existing script section, replacing only the playCurrentStory function

    // Function to play the current story
    function playCurrentStory() {
        if (currentStoryIndex >= currentUserStories.length) {
            // Close modal if all stories are viewed
            const modal = document.getElementById('story-modal');
            if (modal) {
                document.body.removeChild(modal);
            }
            return;
        }

        const currentStory = currentUserStories[currentStoryIndex];
        const storyUrl = '<?php echo base_url('stories/'); ?>' + currentStory.file_path;
        const isOwnStory = currentStory.id_user == CURRENT_USER_ID;
        const timestamp = formatTimestamp(currentStory.created_at);

        // Create progress segments HTML
        let progressSegmentsHTML = '';
        for (let i = 0; i < currentUserStories.length; i++) {
            const isActive = i === currentStoryIndex;
            progressSegmentsHTML += `
            <div class="progress-segment">
                <div class="progress-segment-fill" style="${i < currentStoryIndex ? 'width: 100%' : ''}"></div>
            </div>
        `;
        }

        let storyContent = '';
        if (currentStory.type === 'image') {
            storyContent = `
            <img src="${storyUrl}" class="w-full h-full object-contain" alt="Story">
        `;
        } else if (currentStory.type === 'video') {
            storyContent = `
            <video class="w-full h-full object-contain" autoplay id="story-video">
                <source src="${storyUrl}" type="video/webm">
            </video>
        `;
        }

        // Remove existing modal if there is one
        const existingModal = document.getElementById('story-modal');
        if (existingModal) {
            document.body.removeChild(existingModal);
        }

        // Create custom modal
        const modal = document.createElement('div');
        modal.id = 'story-modal';
        modal.className = 'fixed inset-0 bg-black flex items-center justify-center z-50';
        modal.innerHTML = `
        <div class="story-container w-full h-full mx-auto relative">
            <div class="story-progress-container">
                ${progressSegmentsHTML}
            </div>
            
            <div class="story-header">
                <div class="user-info">
                    <div class="user-avatar" style="background-image: url('${currentUserPhoto}')"></div>
                    <div class="text-white">
                        <div class="font-semibold">${currentUsername}</div>
                        <div class="user-time">${timestamp}</div>
                    </div>
                </div>
                
                <div class="story-actions">
                    ${isOwnStory ? `
                    <div id="delete-story" class="action-button" title="Delete Story">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    ` : ''}
                    <div id="close-story" class="action-button" title="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="story-content h-full flex items-center justify-center">
                ${storyContent}
            </div>
            
            ${currentStory.caption ? `
            <div class="caption-overlay">
                <p class="caption-text">${escapeHtml(currentStory.caption)}</p>
            </div>
            ` : ''}
        </div>
    `;

        document.body.appendChild(modal);

        // Set up event listeners
        document.getElementById('close-story').addEventListener('click', () => {
            clearInterval(storyProgressInterval);
            document.body.removeChild(modal);
        });

        if (isOwnStory) {
            document.getElementById('delete-story').addEventListener('click', () => {
                deleteStory(currentStory.id_story);
            });
        }

        // Add variables to track pause state
        let isPaused = false;
        let savedProgress = 0;
        let totalDuration = 0;

        const storyContainer = modal.querySelector('.story-container');
        const videoEl = modal.querySelector('video');

        // Touch/mouse down event (for holding/pressing)
        storyContainer.addEventListener('mousedown', handleHoldStart);
        storyContainer.addEventListener('touchstart', handleHoldStart);

        // Touch/mouse up event (for releasing)
        document.addEventListener('mouseup', handleHoldEnd);
        document.addEventListener('touchend', handleHoldEnd);

        // Function to handle hold start
        function handleHoldStart(e) {
            // Ignore if clicking on buttons
            if (e.target.closest('.action-button') || e.target.closest('button')) {
                return;
            }

            // Pause the story progress
            pauseStory();
        }

        // Function to handle hold end
        function handleHoldEnd() {
            // Resume the story progress
            resumeStory();
        }

        // Pause story function
        function pauseStory() {
            if (isPaused) return;

            isPaused = true;
            clearInterval(storyProgressInterval);

            // Pause video if it's a video story
            if (videoEl) {
                videoEl.pause();
            }
        }

        // Resume story function
        function resumeStory() {
            if (!isPaused) return;

            isPaused = false;

            // Resume video if it's a video story
            if (videoEl) {
                videoEl.play();
                startProgressTracking(totalDuration);
            } else {
                // For image stories
                startProgressTracking(totalDuration);
            }
        }

        // Handle tap/click for navigation
        storyContainer.addEventListener('click', (e) => {
            // Ignore clicks on buttons
            if (e.target.closest('.action-button') || e.target.closest('button')) {
                return;
            }

            // If paused, resume and return without navigation
            if (isPaused) {
                resumeStory();
                return;
            }

            const screenWidth = window.innerWidth;
            const clickX = e.clientX || (e.touches && e.touches[0].clientX);

            if (clickX < screenWidth / 3) {
                // Previous story
                if (currentStoryIndex > 0) {
                    clearInterval(storyProgressInterval);
                    currentStoryIndex--;
                    playCurrentStory();
                }
            } else {
                // Next story
                clearInterval(storyProgressInterval);
                currentStoryIndex++;
                playCurrentStory();
            }
        });

        // Set up progress tracking
        const progressSegments = modal.querySelectorAll('.progress-segment-fill');
        storyProgressElements.forEach((item, index) => {
            item.element = progressSegments[index];
        });

        let progress = 0;
        const storyDuration = currentStory.type === 'image' ? 5000 : null; // Default duration for image

        if (videoEl) {
            videoEl.addEventListener('loadedmetadata', () => {
                totalDuration = videoEl.duration * 1000;
                startProgressTracking(totalDuration);
            });
        } else {
            totalDuration = storyDuration;
            startProgressTracking(storyDuration);
        }

        // Function to track progress
        function startProgressTracking(duration) {
            // Clear existing interval to prevent multiple intervals running
            clearInterval(storyProgressInterval);

            // Don't start if paused
            if (isPaused) return;

            const currentProgressElement = storyProgressElements[currentStoryIndex].element;

            storyProgressInterval = setInterval(() => {
                progress += 100;
                savedProgress = progress; // Save progress for resume
                const percentage = (progress / duration) * 100;
                currentProgressElement.style.width = `${percentage}%`;

                if (progress >= duration) {
                    clearInterval(storyProgressInterval);
                    currentStoryIndex++;
                    playCurrentStory();
                }
            }, 100);
        }

        // Mark story as viewed
        markStoryAsViewed(currentStory.id_story);
    }

    // Function to mark story as viewed
    function markStoryAsViewed(storyId) {
        $.ajax({
            url: '<?php echo site_url("users/mark_viewed"); ?>',
            method: 'POST',
            data: {
                'storyId': storyId,
                'viewerId': CURRENT_USER_ID
            },
            dataType: 'json',
            success: function(data) {
                if (data.status === 'success') {
                    console.log('Story marked as viewed');
                    updateStoryViews(storyId, data.views_count, data.viewed_by);
                } else {
                    console.error('Error:', data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.log('Response Text:', xhr.responseText);
            }
        });
    }

    // Function to update story view count and viewed_by list in the DOM
    function updateStoryViews(storyId, viewsCount, viewedBy) {
        const storyGroups = document.querySelectorAll('.user-stories-group');
        storyGroups.forEach(group => {
            const storiesData = JSON.parse(group.dataset.stories);
            const updatedStories = storiesData.map(story => {
                if (story.id_story == storyId) {
                    story.viewed_by = viewedBy;
                    story.views_count = viewsCount;
                }
                return story;
            });
            group.dataset.stories = JSON.stringify(updatedStories);
        });
    }

    // Delete a specific story
    function deleteStory(storyId) {
        Swal.fire({
            title: 'Delete story?',
            text: "You won't be able to recover this story",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                clearInterval(storyProgressInterval);

                $.ajax({
                    url: '<?php echo site_url("users/delete_story"); ?>',
                    method: 'POST',
                    data: {
                        'storyId': storyId
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            // Close the story modal
                            const modal = document.getElementById('story-modal');
                            if (modal) {
                                document.body.removeChild(modal);
                            }

                            Swal.fire('Deleted!', 'Your story has been deleted.', 'success');

                            // Remove story from currentUserStories array
                            currentUserStories = currentUserStories.filter(story => story.id_story != storyId);

                            // Update the DOM
                            const storyGroup = document.querySelector(`.user-stories-group[data-user-id="${currentUserId}"]`);
                            if (storyGroup) {
                                if (currentUserStories.length === 0) {
                                    // If no stories left, remove the whole group
                                    storyGroup.remove();
                                } else {
                                    // Update the story count and data
                                    storyGroup.dataset.stories = JSON.stringify(currentUserStories);
                                    const storyCountElement = storyGroup.querySelector('.text-xs');
                                    storyCountElement.textContent = `${currentUserStories.length} stories`;

                                    // Restart story viewing from beginning if there are stories left
                                    if (currentUserStories.length > 0) {
                                        currentStoryIndex = 0;
                                        playCurrentStory();
                                    }
                                }
                            }
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred while deleting the story.', 'error');
                    }
                });
            }
        });
    }

    // Delete all stories from a user
    function deleteAllUserStories(userId) {
        Swal.fire({
            title: 'Delete all stories?',
            text: "You won't be able to recover these stories",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete All'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo site_url("users/delete_all_stories"); ?>',
                    method: 'POST',
                    data: {
                        'userId': userId
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            Swal.fire('Deleted!', 'All your stories have been deleted.', 'success');

                            // Remove the user's story group from DOM
                            const storyGroup = document.querySelector(`.user-stories-group[data-user-id="${userId}"]`);
                            if (storyGroup) {
                                storyGroup.remove();
                            }

                            // Close the story modal if it's open
                            const modal = document.getElementById('story-modal');
                            if (modal) {
                                document.body.removeChild(modal);
                            }
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred while deleting the stories.', 'error');
                    }
                });
            }
        });
    }

    // Document ready event
    document.addEventListener('DOMContentLoaded', () => {
        const storyGroups = document.querySelectorAll('.user-stories-group');
        storyGroups.forEach(group => {
            group.addEventListener('click', () => showUserStories(group));
        });
    });

    // Story search function
    function filterStories() {
        const query = document.getElementById('search-story').value.toLowerCase();
        const storyGroups = document.querySelectorAll('.user-stories-group');

        storyGroups.forEach(group => {
            const userName = group.querySelector('h3').textContent.toLowerCase();

            if (userName.includes(query)) {
                group.style.display = 'block';
            } else {
                group.style.display = 'none';
            }
        });
    }

    function escapeHtml(text) {
        if (!text) return '';

        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) {
            return map[m];
        });
    }
</script>