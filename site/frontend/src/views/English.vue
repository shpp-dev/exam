<template>
  <v-layout justify-center>
    <v-flex xs8 pt-3>

      <!-- Title -->
      <div class="mt-4 mb-4 text-xs-center">
        <h1 class="display-1 text-uppercase font-weight-light">{{$t('english.title')}}</h1>
        <h6
          class="text-xs-center subheading ma-3"
          :class="{
            'green--text text--lighten-1': !isDangerRemaining,
            'red--text': isDangerRemaining
         }"
        >
          {{$t('remaining_time')}}: {{remaining}}
        </h6>
      </div>

      <!-- Content block -->
      <v-layout justify-center>
        <v-flex xs8>
          <v-card dark v-if="!finished" flat class="english__window">
            <v-card-text>
              <v-layout align-center mb-3>
                <v-avatar
                  color="green lighten-1"
                  class="subheading white--text mr-3"
                  size="35"
                  v-text="task.taskNumber"
                ></v-avatar>
                <strong class="subheading" v-html="task.question"></strong>
              </v-layout>

              <v-divider></v-divider>

              <div>
                <v-radio-group v-model="selectedAnswer" column>
                  <v-radio
                    v-for="(answer, index) in task.answers"
                    :key="index"
                    :label="answer"
                    :value="index + 1"
                    color="orange lighten-2"
                  ></v-radio>
                </v-radio-group>
              </div>
            </v-card-text>
          </v-card>

          <v-card dark v-if="finished" flat class="english__window">
            <v-card-text>
              <v-layout align-center justify-center mb-3>
               <span class="text-xs-center title font-weight-regular">{{$t('english.result')}}</span>
              </v-layout>

              <v-layout alight-center justify-center>
                <span class="display-3 font-weight-light success--text">
                  {{score}} / {{tasksAmount}}
                </span>
              </v-layout>
            </v-card-text>
          </v-card>

          <!-- Buttons -->
          <div class="text-xs-center mt-3">
            <v-btn
              :loading="answerLoading"
              outline
              v-if="!finished"
              @click="saveAnswer"
              color="green lighten-1"
            >
              {{$t('send_answer')}}
            </v-btn>
            <v-btn
              outline
              v-if="finished"
              @click="exit"
              color="orange accent-3"
            >
              {{$t('finish_test')}}
            </v-btn>
          </div>
        </v-flex>
      </v-layout>

    </v-flex>
  </v-layout>
</template>

<script lang="ts">
import Vue from "vue";
import store from "@/store";
import statusCodes from "@/config/status-codes";

export default Vue.extend({
  name: "English",

  data() {
    return {
      task: {
        taskNumber: 0
      },
      tasksAmount: 0,
      finished: false,
      tick: null as any,
      isDangerRemaining: false,
      selectedAnswer: 1,
      score: 0,
      answerLoading: false
    };
  },

  computed: {
    remaining(): number {
      this.isDangerRemaining = this.$store.state.english.remainingTime < 5;
      return this.$store.state.english.remainingTime;
    },
    deadline(): boolean {
      return this.$store.state.english.remainingTime == 0;
    },
    english(): any {
      return this.$store.state.english;
    }
  },

  watch: {
    async remaining() {
      if (this.deadline) {
        clearInterval(this.tick);
        await this.$store.dispatch("english/finish");
        this.finished = true;
      }
    }
  },

  async beforeRouteEnter(to, from, next) {
    try {
      Vue.set(store.state.english, "loading", true);
      await store.dispatch("english/getQuestion");
      await store.dispatch("english/getRemainingTime");
      Vue.set(store.state.english, "loading", false);
      next();
    } catch (e) {
      Vue.set(store.state.english, "loading", false);

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
    Vue.set(this.$store.state.general.examsList.english, "finished", this.finished);
    Vue.set(this.$store.state.general.examsList.english, "started", !this.finished);
    next();
  },

  mounted() {
    this.task = this.english.task;
    this.tasksAmount = this.english.tasksAmount;
    this.selectedAnswer = 1;
    this.tick = setInterval(() => {
      this.$store.dispatch("english/getRemainingTime");
    }, 60000);
  },

  methods: {
    async getQuestion() {
      try {
        await this.$store.dispatch("english/getQuestion");
        this.task = this.english.task;
        this.tasksAmount = this.english.tasksAmount;
        this.selectedAnswer = 1;
      } catch (e) {
        Vue.set(this.$store.state.general, "exception", true);
      }
    },

    async saveAnswer() {
      this.answerLoading = true;

      try {
        await this.$store.dispatch("english/saveAnswer", {
          taskNumber: this.task.taskNumber,
          answer: this.selectedAnswer
        });

        this.finished = this.english.finished;
        this.score = this.english.score;

        if (!this.finished) {
          await this.getQuestion();
        }
      } catch (e) {
        Vue.set(this.$store.state.general, "exception", true);
      }

      this.answerLoading = false;
    },

    exit() {
      this.$router.push({name: "home"});
    }
  }
});
</script>

<style>
  .v-input {
    justify-content: center;
  }

  .english__window {
    min-height: 260px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>
