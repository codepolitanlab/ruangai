<div id="quiz" x-data="lesson_quiz(data.lesson?.quiz)">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
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

            <template x-if="currentQuiz">
                <div>
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
                            <button class="btn btn-outline-primary" @click="prevQuiz" x-transition x-show="currentIndex > 0">Sebelumnya</button>
                        </div>
                        <div>
                            <button class="btn btn-outline-primary" @click="nextQuiz" x-transition x-show="currentIndex < quizKeys.length - 1">Selanjutnya</button>
                            <button class="btn btn-success" @click="finishQuiz" x-transition x-show="Object.keys(answers).length === quizKeys.length">Cek Jawaban</button>
                        </div>
                    </div>
                </div>
            </template>

        </div>
    </div>
</div>