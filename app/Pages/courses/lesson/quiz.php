<div id="quiz" x-data="lesson_quiz(data.lesson?.quiz, data.lesson?.course_id, data.lesson?.id)">

    
    <!-- 🎉 Animasi Partikel Selebrasi -->
    

    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- TEMPLATE Cover Quiz -->
            <template x-if="!startQuiz">
                <div class="text-center">
                    <div class="card-body">
                        <p x-text="data.lesson.quiz_description"></p>
                        <button class="btn btn-lg btn-primary" @click="startQuiz = true">Mulai Quiz</button>
                    </div>
                </div>
            </template>

            <!-- TEMPLATE Pertanyaan -->
            <template x-if="currentQuiz && startQuiz && Object.keys(result).length == 0">
                <div>
                    <!-- Pagination -->
                    <div class="mb-3" x-show="startQuiz && Object.keys(result).length == 0">
                        <div class="row align-items-center">
                            <template x-for="(key, index) in quizKeys" :key="key">
                                <button
                                    class="col shadow-none border rounded me-1"
                                    style="height:10px"
                                    :class="currentIndex === index 
                                    ? (answers[key] ? 'btn-success py-2' : 'btn-warning py-2')
                                    : (answers[key] ? 'btn-success' : 'btn-outline-secondary')"
                                    @click="goTo(index)">
                                    <span>&nbsp;</span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Card Pertanyaan -->
                    <div class="card mb-4 shadow-lg quiz-item" :id="key">
                        <div class="card-body">
                            <h6 class="h6" x-text="currentQuiz.question"></h6>

                            <!-- TRUE/FALSE -->
                            <template x-if="currentQuiz.type === 'true_false'">
                                <div class="mt-3">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            :name="'answer_' + currentKey"
                                            value="true"
                                            :id="'true_' + currentKey"
                                            @change="storeAnswer(currentKey, 'true')"
                                            :checked="answers[currentKey] === 'true'">
                                        <label class="form-check-label" :for="'true_' + currentKey">Benar</label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            :name="'answer_' + currentKey"
                                            value="false"
                                            :id="'false_' + currentKey"
                                            @change="storeAnswer(currentKey, 'false')"
                                            :checked="answers[currentKey] === 'false'">
                                        <label class="form-check-label" :for="'false_' + currentKey">Salah</label>
                                    </div>
                                </div>
                            </template>

                            <!-- MULTIPLE CHOICE -->
                            <template x-if="currentQuiz.type === 'multiple_choice'">
                                <div class="mt-3">
                                    <template x-for="(optionText, optionKey) in currentQuiz.options" :key="optionKey">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :name="'answer_' + currentKey"
                                                :value="optionKey"
                                                :id="optionKey + '_' + currentKey"
                                                @change="storeAnswer(currentKey, optionKey)"
                                                :checked="answers[currentKey] === optionKey">
                                            <label class="form-check-label" :for="optionKey + '_' + currentKey" x-text="`${optionText}`"></label>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <button class="btn btn-outline-primary" @click="prevQuiz" x-transition x-show="currentIndex > 0"><i class="bi bi-caret-left m-0"></i></button>
                            <button class="btn btn-outline-primary" @click="nextQuiz" x-transition x-show="currentIndex < quizKeys.length - 1"><i class="bi bi-caret-right m-0"></i></button>
                        </div>
                        <div>

                            <button class="btn btn-success" :class="{ 'btn-progress': finishQuiz }" @click="submitQuiz" x-transition x-show="Object.keys(answers).length === quizKeys.length">Cek Jawaban</button>
                        </div>
                    </div>
                </div>
            </template>

            <!-- TEMPLATE Hasil Quiz -->
            <template x-if="Object.keys(result).length > 0">
                <div>
                    <h5 class="text-center">Hasil Quiz</h5>
                    <h2 class="text-center"
                        :class="result.is_pass ? 'text-success' : 'text-danger'"
                        x-text="`Skor Anda: ` + Math.round(result.score)"></h2>

                    <!-- Jika Belum Lulus -->
                    <div class="text-center pb-5 mb-5 border-bottom" x-show="!result.is_pass">
                        <div class="display-2 mb-3">😔</div>
                        <p class="lead">Dapatkan minimum skor <strong class="fw-bold" x-text="result.min_score"></strong> pada quiz ini untuk dapat melanjutkan materi.</p>
                        <button class="btn btn-outline-primary" @click="tryAgain">
                            <i class="bi bi-arrow-clockwise"></i>
                            Ulangi Quiz
                        </button>
                    </div>

                    <!-- Jika Lulus -->
                    <div class="text-center pb-5 mb-5 border-bottom" x-show="result.is_pass">
                        <div class="display-2 mb-3">👏🏻😎</div>
                        <p class="lead">Kamu keren!<br> Yuk lanjutkan belajar ke materi selanjutnya.</p>

                        <a :href="`/courses/${data.lesson.course_id}/lesson/${data.lesson?.next_lesson.id}`"
                            class="btn btn-outline-primary rounded-pill ps-4 pe-3 py-4">
                            <div class="text-end me-3 mt-2">
                                <span class="">Materi Selanjutnya</span><br>
                                <h5 class="h6 " x-text="data.lesson?.next_lesson.lesson_title"></h5>
                            </div>
                            <i class="bi bi-arrow-right me-2"></i>
                        </a>
                    </div>

                    <h4>Ulasan Jawaban</h4>
                    <div class="card mb-4">
                        <div class="card-body">
                            <template x-for="(quiz, key) in quizzes" :key="key">
                                <div class="mb-4 p-3"
                                    :class="result.hasil[key].benar ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10'">
                                    <h5 class="h6" x-text="quiz.question"></h5>

                                    <!-- TRUE/FALSE -->
                                    <template x-if="quiz.type === 'true_false'">
                                        <div class="mt-3">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :name="'answer_' + key"
                                                    value="true"
                                                    :checked="result.hasil[key].jawaban === 'true'"
                                                    readonly>
                                                <label class="form-check-label" :for="'true_' + key">
                                                    Benar
                                                    <i class="bi ms-2 fs-5"
                                                        x-show="result.hasil[key].jawaban === 'true'"
                                                        :class="result.hasil[key].benar ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger'"></i>
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :name="'answer_' + key"
                                                    value="false"
                                                    :checked="result.hasil[key].jawaban === 'false'"
                                                    readonly>
                                                <label class="form-check-label" :for="'false_' + key">
                                                    Salah
                                                    <i class="bi ms-2 fs-5"
                                                        x-show="result.hasil[key].jawaban === 'false'"
                                                        :class="result.hasil[key].benar ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger'"></i>
                                                </label>
                                            </div>
                                            <p class="mt-3 mb-1 fs-6 text-success-darker" x-show="result.hasil[key].benar">
                                                <strong>Penjelasan:</strong><br>
                                                <span x-text="result.hasil[key].penjelasan"></span>
                                            </p>
                                        </div>
                                    </template>

                                    <!-- MULTIPLE CHOICE -->
                                    <template x-if="quiz.type === 'multiple_choice'">
                                        <div class="mt-3">
                                            <template x-for="(optionText, optionKey) in quiz.options" :key="optionKey">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        :name="'answer_' + key"
                                                        :value="optionKey"
                                                        :id="optionKey + '_' + key"
                                                        :checked="result.hasil[key].jawaban === optionKey"
                                                        readonly>
                                                    <label class="form-check-label">
                                                        <span x-text="`${optionKey}. ${optionText}`"></span>
                                                        <i class="bi ms-2 fs-5"
                                                            x-show="result.hasil[key].jawaban === optionKey"
                                                            :class="result.hasil[key].benar ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger'"></i>
                                                    </label>
                                                </div>
                                            </template>
                                            <p class="mt-3 mb-1 fs-6 text-success-darker" x-show="result.hasil[key].benar">
                                                <strong>Penjelasan:</strong><br>
                                                <span x-text="result.hasil[key].penjelasan"></span>
                                            </p>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

        </div>
    </div>
</div>