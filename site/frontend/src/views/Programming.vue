<template>
  <v-layout class="pt-3" column>

    <!-- Title -->
    <div class="mt-4 mb-2 text-xs-center">
      <h1 class="display-1 font-weight-light text-uppercase programming__title">{{$t('programming.title')}}</h1>
      <h6 class="text-xs-center subheading mt-3"
          :class="{
            'green--text text--lighten-1': !isDangerRemaining,
            'red--text': isDangerRemaining
         }"
      >
        {{$t('remaining_time')}}: {{remaining}}
      </h6>
    </div>

    <!-- Stepper -->
    <v-stepper v-model="taskNumber">
      <v-stepper-header>
        <template v-for="n in taskIds">
          <v-stepper-step
            :key="`${n}-step`"
            :complete="taskNumber > n"
            :step="n"
            color="green"
          >
            {{$t('task')}} {{n}}
          </v-stepper-step>

          <v-divider
            v-if="n !== taskIds.length - 1"
            :key="n"
          ></v-divider>
        </template>
      </v-stepper-header>
    </v-stepper>

    <!-- Programming task -->
    <div class="mb-2">
      <ProgrammingTask
        v-if="programmingTask"
        :task="programmingTask"
        :lang="lang"
        @changeFunction="saveFunction"
      ></ProgrammingTask>
    </div>

    <!-- Buttons -->
    <v-layout justify-center>
      <v-btn
        :loading="testLoading"
        outline
        color="green lighten-1"
        class="programming__btn"
        :disabled="submitLoading"
        @click="checkAnswer"
      >
         {{$t('programming.test_code')}}
      </v-btn>

      <v-btn
        :loading="submitLoading"
        outline
        color="green lighten-1"
        class="programming__btn"
        :disabled="testLoading"
        @click="submitAnswer"
      >
        {{$t('send_answer')}}
      </v-btn>

      <v-btn
        outline
        color="orange accent-3"
        class="programming__btn"
        :disabled="submitLoading || testLoading"
        @click="exitRequest = true"
      >
        {{$t('finish_test')}}
      </v-btn>
    </v-layout>

    <!-- Dialogs -->
    <div class="text-xs-center">
      <v-dialog light v-model="resultDialog" width="500">
        <v-card>
          <v-card-text class="text-xs-center font-weight-medium">
            {{this.resultMessage}}
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="green"
              flat
              @click="resultDialog = false"
            >
              {{$t('ok')}}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog persistent light v-if="tick" v-model="deadline" width="500">
        <v-card>
          <v-card-text class="text-xs-center">
            {{$t('programming.deadline.title')}}
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="green"
              flat
              @click="exit"
            >
              {{$t('exit')}}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog light v-model="exitRequest" width="500">
        <v-card>
          <v-card-text class="text-xs-center">
            {{$t('programming.finish.title')}}
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="green"
              flat
              @click="finishTest"
            >
              {{$t('yes')}}
            </v-btn>
            <v-btn
              color="green"
              flat
              @click="exitRequest = false"
            >
              {{$t('no')}}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog
        v-model="loading"
        hide-overlay
        persistent
        width="300"
      >
        <v-card
          light
        >
          <v-card-text>
            {{$t('please_wait')}}
            <v-progress-linear
              indeterminate
              color="green lighten-1"
              class="mb-0"
            ></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>
  </v-layout>
</template>

<script lang="ts">
import Vue from "vue";
import ProgrammingTask from "@/components/ProgrammingTask.vue";
import store from "@/store/index";
import statusCodes from "@/config/status-codes";

export default Vue.extend({
  name: "Programming",
  components: {
    ProgrammingTask
  },
  data() {
    return {
      programmingTask: {
        number: 0,
        deadlineTs: 0,
        functionStart: {
          js: "",
          java: "",
          cpp: ""
        }
      },
      taskIds: [0, 1, 2, 3, 4, 5], // todo get tasks amount from backend
      tick: null as any,
      isDangerRemaining: false,
      taskNumber: 0,
      lang: "js",
      userFunction: "",
      resultMessage: "",
      resultDialog: false,
      exitRequest: false,
      testLoading: false,
      submitLoading: false,
      finished: false
    };
  },

  computed: {
    remaining(): number {
      this.isDangerRemaining = this.$store.state.programming.remainingTime < 10;
      return this.$store.state.programming.remainingTime;
    },
    deadline(): boolean {
      return this.$store.state.programming.remainingTime == 0;
    },
    programming(): any {
      return this.$store.state.programming;
    },
    loading(): boolean {
      return this.testLoading || this.submitLoading;
    }
  },

  watch: {
    async remaining() {
      if (this.deadline) {
        clearInterval(this.tick);
        await this.$store.dispatch("programming/finish");
        this.finished = true;
      }
    }
  },

  mounted() {
    this.programmingTask = this.programming.task;

    if (this.programmingTask) {
      this.taskNumber = this.programmingTask.number;
      this.userFunction = this.programmingTask.functionStart[this.lang];
      this.tick = setInterval(() => {
        this.$store.dispatch("programming/getRemainingTime");
      }, 60000);
    }
  },

  async beforeRouteEnter(to, from, next) {
    try {
      Vue.set(store.state.programming, "loading", true);
      await store.dispatch("programming/getTask");
      await store.dispatch("programming/getRemainingTime");
      Vue.set(store.state.programming, "loading", false);

      next();
    } catch (e) {
      Vue.set(store.state.programming, "loading", false);

      if (e.code === statusCodes.NOT_ACTIVE_EXAM
        || e.code === statusCodes.NOT_ACTIVE_SESSION
        || e.code === statusCodes.CONCURRENT_EXAM) {
        next("/");
      } else {
        Vue.set(store.state.general, "exception", true);
      }
    }
  },

  beforeRouteLeave(to, from, next) {
    clearInterval(this.tick);
    Vue.set(this.$store.state.general.examsList.programming, "finished", this.finished);
    Vue.set(this.$store.state.general.examsList.programming, "started", !this.finished);
    next();
  },

  methods: {
    async checkAnswer() {
      this.testLoading = true;

      try {
        await this.$store.dispatch("programming/saveAnswer", {
          action: "test",
          taskNumber: this.taskNumber,
          lang: this.lang,
          userFunction: this.userFunction
        });

        if (this.programming.error) {
          this.resultMessage = this.programming.message;
        } else {
          this.resultMessage = this.getResultMessage();
        }

        this.resultDialog = true;
      } catch (e) {
        Vue.set(this.$store.state.general, "exception", true);
      }

      this.testLoading = false;
    },

    async submitAnswer() {
      this.submitLoading = true;

      try {
        await this.$store.dispatch("programming/saveAnswer", {
          action: "submit",
          taskNumber: this.taskNumber,
          lang: this.lang,
          userFunction: this.userFunction
        });

        if (this.programming.error) {
          this.resultMessage = this.programming.message;
          this.resultDialog = true;
        } else {
          if (this.programming.finished) {
            this.finished = true;
            this.exit();
            return;
          }

          await this.$store.dispatch("programming/getTask");
          this.programmingTask = this.programming.task;
          this.taskNumber = this.programmingTask.number;
        }
      } catch (e) {
        Vue.set(this.$store.state.general, "exception", true);
      }

      this.submitLoading = false;
    },

    async finishTest() {
      try {
        await this.$store.dispatch("programming/finish");
        this.finished = true;
        this.exit();
      } catch (e) {
        Vue.set(this.$store.state.general, "exception", true);
      }
    },

    saveFunction(data) {
      this.taskNumber = data.taskNumber;
      this.lang = data.lang;
      this.userFunction = data.userFunction;
    },

    getResultMessage(): string {
      let passedCount = 0;

      this.programming.resultCases.forEach((passed) => {
        if (passed) {
          passedCount++;
        }
      });

      return this.$t("programming.testResult", {
        passed: passedCount,
        all: this.programming.resultCases.length
      }).toString();
    },

    exit() {
      this.$router.push({name: "home"});
    }
  }

});
</script>

<style lang="scss">
  .card {
    padding: 1rem;
  }

  .programming__btn {
    width: 200px;
  }

  .programming__stepper {
    height: 100%;
  }

  .programming__toolbar {
    display: flex;
    align-items: flex-end;
    justify-content: flex-end;
    width: 100%;
  }
</style>
