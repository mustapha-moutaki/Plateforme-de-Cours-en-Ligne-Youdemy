<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- TinyMCE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    <style>
        .form-control, .form-select {
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #0a58ca;
            transform: translateY(-2px);
        }
        .btn-primary:active {
            background-color: #0d6efd;
            transform: translateY(0);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <?php include_once '../../public/components/sidebar.php'; ?>

    <main class="main-content position-relative vh-100">
        <?php include_once '../../public/components/header.php'; ?>

        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <h1 class="card-title text-center mb-4">Create New Course</h1>
                            
                            <form id="courseForm">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-semibold">Course Title</label>
                                    <input type="text" class="form-control" id="title" required placeholder="Enter course title">
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label fw-semibold">Course Description</label>
                                    <textarea class="form-control" id="description" required></textarea>
                                </div>

                                <!-- Content Type -->
                                <div class="mb-3">
                                    <label for="contentType" class="form-label fw-semibold">Content Type</label>
                                    <select class="form-select" id="contentType" required>
                                        <option value="">Select content type</option>
                                        <option value="video">Video</option>
                                        <option value="document">Document</option>
                                    </select>
                                </div>

                                <!-- Dynamic Content Input (Video/Document) -->
                                <div id="contentInput" class="mb-3 d-none"></div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="category" class="form-label fw-semibold">Category</label>
                                    <select class="form-select" id="category" required>
                                        <option value="">Select category</option>
                                        <option value="web-development">Web Development</option>
                                        <option value="data-science">Data Science</option>
                                        <option value="mobile-dev">Mobile Development</option>
                                        <option value="ui-ux">UI/UX Design</option>
                                        <option value="cloud">Cloud Computing</option>
                                    </select>
                                </div>

                                <!-- Tags -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tags</label>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags" value="html" id="htmlCheck">
                                                <label class="form-check-label" for="htmlCheck">HTML</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags" value="css" id="cssCheck">
                                                <label class="form-check-label" for="cssCheck">CSS</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags" value="javascript" id="jsCheck">
                                                <label class="form-check-label" for="jsCheck">JavaScript</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags" value="python" id="pythonCheck">
                                                <label class="form-check-label" for="pythonCheck">Python</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags" value="react" id="reactCheck">
                                                <label class="form-check-label" for="reactCheck">React</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags" value="node" id="nodeCheck">
                                                <label class="form-check-label" for="nodeCheck">Node.js</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100">

                                    Publish Course
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once '../../public/components/footer.php'; ?>
    </main>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#description',
            height: 300,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 16px; }'
        });

        // Handle content type change
        const contentTypeSelect = document.getElementById('contentType');
        const contentInputDiv = document.getElementById('contentInput');

        contentTypeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            if (!selectedType) {
                contentInputDiv.classList.add('d-none');
                contentInputDiv.innerHTML = '';
                return;
            }

            contentInputDiv.classList.remove('d-none');
            
            if (selectedType === 'video') {
                contentInputDiv.innerHTML = `
                    <div>
                        <label for="videoUrl" class="form-label">Video URL</label>
                        <input type="url" class="form-control" id="videoUrl" required
                            placeholder="Enter video URL (YouTube, Vimeo, etc.)">
                    </div>
                `;
            } else if (selectedType === 'document') {
                contentInputDiv.innerHTML = `
                    <div>
                        <label for="documentFile" class="form-label">Upload Document</label>
                        <input type="file" class="form-control" id="documentFile" required 
                            accept=".pdf,.doc,.docx">
                    </div>
                `;
            }
        });

        // Handle form submission
        document.getElementById('courseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Gather selected tags
            const selectedTags = Array.from(document.querySelectorAll('input[name="tags"]:checked'))
                .map(checkbox => checkbox.value);

            // Create course object
            const courseData = {
                title: document.getElementById('title').value,
                description: tinymce.get('description').getContent(),
                contentType: document.getElementById('contentType').value,
                category: document.getElementById('category').value,
                tags: selectedTags,
                content: contentTypeSelect.value === 'video' 
                    ? document.getElementById('videoUrl')?.value 
                    : document.getElementById('documentFile')?.files[0]?.name
            };

            console.log('Course Data:', courseData);
            alert('Course published successfully!');
            this.reset();
            tinymce.get('description').setContent('');
            contentInputDiv.classList.add('d-none');
            contentInputDiv.innerHTML = '';
        });
    </script>
</body>
</html>
