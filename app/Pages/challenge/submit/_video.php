<div class="card rounded-4 mb-3">
    <div class="card-body">
        <!-- All fields combined into a single section -->
        <div>
            <h5 class="mb-3">Informasi Video</h5>

            <div class="col-12 mb-4">
                <label class="form-label">Twitter Post URL</label>
                <input type="url" class="form-control" x-model="form.twitter_post_url"
                    placeholder="https://twitter.com/username/status/123456">
                <i class="clear-input"><i class="bi bi-close-circle"></i></i>

                <template x-if="errors.twitter_post_url">
                    <small class="text-danger" x-text="errors.twitter_post_url"></small>
                </template>
            </div>

            <div class="col-12 mb-4">
                <label class="form-label">Video Title</label>
                <input type="text" class="form-control" x-model="form.video_title"
                    placeholder="Judul video Anda (min. 5 karakter)">
                <i class="clear-input"><i class="bi bi-close-circle"></i></i>

                <template x-if="errors.video_title">
                    <small class="text-danger" x-text="errors.video_title"></small>
                </template>
            </div>

            <div class="col-12 mb-4">
                <label class="form-label">Video Description</label>
                <textarea class="form-control" rows="3" x-model="form.video_description"
                    placeholder="Deskripsikan video Anda (min. 10 karakter)"></textarea>

                <template x-if="errors.video_description">
                    <small class="text-danger" x-text="errors.video_description"></small>
                </template>
            </div>

            <div class="col-12 mb-4">
                <label class="form-label">Prompt File (PDF/TXT)</label>
                <input type="file" class="form-control" @change="handleFileUpload($event, 'prompt_file')"
                    accept=".pdf,.txt">

                <small class="text-muted">Upload full prompt yang digunakan</small>
                <template x-if="errors.prompt_file">
                    <small class="text-danger" x-text="errors.prompt_file"></small>
                </template>
                <template x-if="files.prompt_file">
                    <div class="badge bg-success mt-1" x-text="files.prompt_file.name"></div>
                </template>
                <template x-if="!files.prompt_file && existingFiles.prompt_file">
                    <div class="badge bg-info mt-1" x-text="existingFiles.prompt_file"></div>
                </template>
            </div>

            <!-- <div class="col-12 mb-4">
                <label class="form-label">Twitter Follow Screenshot</label>
                <input type="file" class="form-control" @change="handleFileUpload($event, 'twitter_follow_screenshot')"
                    accept="image/*">
                <small class="text-muted">Screenshot follow @codepolitan & @alibaba_cloud</small>

                <template x-if="errors.twitter_follow_screenshot">
                    <small class="text-danger" x-text="errors.twitter_follow_screenshot"></small>
                </template>
                <template x-if="files.twitter_follow_screenshot">
                    <div class="badge bg-success mt-1" x-text="files.twitter_follow_screenshot.name"></div>
                </template>
                <template x-if="!files.twitter_follow_screenshot && existingFiles.twitter_follow_screenshot">
                    <div class="badge bg-info mt-1" x-text="existingFiles.twitter_follow_screenshot"></div>
                </template>
            </div> -->

            <template x-if="errors.files">
                <div class="alert alert-danger" x-text="errors.files"></div>
            </template>

            <!-- Nothing to navigate between - single page -->
        </div>
    </div>
</div>