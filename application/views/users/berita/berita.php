<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: -10px;
            padding: 20px 0px;
        }

        .blog-post {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            background-color: #fff;
            max-width: 600px;
            width: 100%;
            box-sizing: border-box;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
            overflow: hidden;
        }

        .blog-post:hover {
            transform: scale(1.05);
        }


        .blog-post img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .blog-post h2 {
            font-size: 16px;
            margin: 10px 0;
        }

        .blog-post p {
            font-size: 16px;
        }

        .blog-post a {
            color: #333;
            text-decoration: none;
        }

        /* Style for the date paragraph */
        .blog-post .post-date {
            font-size: 12px;
            /* Adjust the font size as needed */
            color: #888;
            /* Adjust the color as needed */
        }

        .read-more {
            display: block;
            text-align: right;
            margin-top: 10px;
        }

/* Skeleton loading styles */
.skeleton {
            background-color: #ddd;
            border-radius: 10px;
            animation: pulse 1.5s infinite ease-in-out;
        }

        .skeleton-text {
            width: 80%;
            height: 20px;
            margin-bottom: 10px;
            background-color: #e0e0e0;
        }

        .skeleton-img {
            width: 100%;
            height: 150px;
            margin-bottom: 10px;
            background-color: #e0e0e0;
        }

        .skeleton-title {
            width: 60%;
            height: 20px;
            margin-bottom: 10px;
            background-color: #e0e0e0;
        }

        .skeleton-date {
            width: 30%;
            height: 15px;
            background-color: #e0e0e0;
            margin-bottom: 10px;
        }

        @keyframes pulse {
            0% {
                background-color: #ddd;
            }

            50% {
                background-color: #ccc;
            }

            100% {
                background-color: #ddd;
            }
        }
    </style>
</head>

<body>
    <!-- Main content -->
    <div class="container">
        <div class="content">
            <div class="row" id="blog-posts">
                <!-- Skeleton loading placeholders -->
                <div class="blog-post skeleton">
                    <div class="skeleton-img"></div>
                    <div class="skeleton-text"></div>
                    <div class="skeleton-text" style="width: 60%;"></div>
                </div>
                <div class="blog-post skeleton">
                    <div class="skeleton-img"></div>
                    <div class="skeleton-text"></div>
                    <div class="skeleton-text" style="width: 60%;"></div>
                </div>
                <div class="blog-post skeleton">
                    <div class="skeleton-img"></div>
                    <div class="skeleton-text"></div>
                    <div class="skeleton-text" style="width: 60%;"></div>
                </div>
                <div class="blog-post skeleton">
                    <div class="skeleton-img"></div>
                    <div class="skeleton-text"></div>
                    <div class="skeleton-text" style="width: 60%;"></div>
                </div>
                <div class="blog-post skeleton">
                    <div class="skeleton-img"></div>
                    <div class="skeleton-text"></div>
                    <div class="skeleton-text" style="width: 60%;"></div>
                </div>
                <!-- Add more skeletons as needed -->
            </div>
        </div>
    </div>


    <!-- JavaScript to fetch and display individual blog posts -->

    <script>
        const apiUrl = 'https://bmtmelati.com/wp-json/wp/v2/posts';

        async function getMediaData(mediaId) {
            const response = await fetch(`https://bmtmelati.com/wp-json/wp/v2/media/${mediaId}`);
            if (response.ok) {
                return await response.json();
            }
            return null;
        }

        async function fetchBlogPosts() {
            try {
                const response = await fetch(apiUrl);
                const data = await response.json();
                const blogContainer = document.getElementById('blog-posts');

                // Clear existing skeletons before adding real content
                blogContainer.innerHTML = '';

                // Limit the number of posts displayed
                const numberOfPostsToShow = 5;
                const slicedData = data.slice(0, numberOfPostsToShow);

                slicedData.forEach(async post => {
                    const postTitle = post.title.rendered;
                    const postId = post.id; // Extract the post ID
                    const postLink = `<?= base_url('users/blog/blog/') ?>${postId}`; // Construct the post link
                    const postDate = new Date(post.date).toLocaleDateString(); // Get the post date
                    const featuredMediaId = post.featured_media;
                    const mediaData = await getMediaData(featuredMediaId);

                    if (mediaData && mediaData.source_url) {
                        // Create a div for each blog post with title, thumbnail, and "Read More" link
                        const postElement = document.createElement('div');
                        postElement.className = 'blog-post';

                        // Create an anchor element for the thumbnail
                        const thumbnailLink = document.createElement('a');
                        thumbnailLink.href = postLink;
                        // Create an image element for the thumbnail
                        const thumbnailElement = document.createElement('img');
                        thumbnailElement.src = mediaData.source_url;
                        thumbnailElement.alt = postTitle;
                        thumbnailElement.loading = 'lazy';
                        // Append the image to the anchor
                        thumbnailLink.appendChild(thumbnailElement);

                        // Create an anchor element for the title
                        const titleLink = document.createElement('a');
                        titleLink.href = postLink;
                        titleLink.textContent = postTitle;

                        // Create a heading for the title
                        const titleHeading = document.createElement('h2');
                        titleHeading.appendChild(titleLink);

                        // Create a paragraph for the date
                        const dateParagraph = document.createElement('p');
                        dateParagraph.textContent = postDate;
                        dateParagraph.classList.add('post-date'); // Add a class for styling the date

                        // Create a "Read More" link as a Bootstrap button and float it to the right
                        const readMoreLink = document.createElement('a');
                        readMoreLink.href = postLink;

                        // Append elements to the post container
                        postElement.appendChild(thumbnailLink);
                        postElement.appendChild(titleHeading);
                        postElement.appendChild(dateParagraph);
                        postElement.appendChild(readMoreLink);

                        blogContainer.appendChild(postElement);
                    }
                });
            } catch (error) {
                console.error('Error fetching blog data:', error);
            }
        }

        fetchBlogPosts();
    </script>

</body>

</html>