<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <v-layout justify-center>
    <v-flex xs8 pt-3>

      <!-- Title -->
      <div class="mt-4 mb-4 text-xs-center">
        <h3 class="display-1 text-uppercase font-weight-light">{{$t('speed_typing.title')}}</h3>
      </div>

      <!-- Rating -->
      <v-stepper
        v-model.number="typingSpeed"
      >
        <v-stepper-header>
          <v-stepper-step color="green" :complete="typingSpeed > 1 && typingSpeed <= 70" step="0">{{$t('speed_typing.trainee')}} (< 70)</v-stepper-step>
          <v-divider></v-divider>
          <v-stepper-step color="green" :complete="typingSpeed > 70 && typingSpeed <= 150" step="1">{{$t('speed_typing.junior')}} (71-150)</v-stepper-step>
          <v-divider></v-divider>
          <v-stepper-step color="green" :complete="typingSpeed > 150 && typingSpeed <= 250" step="2">{{$t('speed_typing.middle')}} (151-250)</v-stepper-step>
          <v-divider></v-divider>
          <v-stepper-step color="green" :complete="typingSpeed > 250" step="3">{{$t('speed_typing.senior')}} (> 250)</v-stepper-step>
        </v-stepper-header>
      </v-stepper>

      <!-- Buttons -->
      <div class="text-xs-center mb-4 mt-4">
        <v-btn
          outline
          class="speed-typing__button"
          v-if="currentAttempt === 0"
          color="green lighten-1"
          v-on:click="startTest"
        >
          {{$t('speed_typing.try')}}
        </v-btn>
        <v-btn
          outline
          class="speed-typing__button"
          v-if="currentAttempt > 0 && currentAttempt < attemptsNum"
          :disabled="generationProcess || !finished"
          color="green lighten-1"
          v-on:click="startTest"
        >
          {{$t('speed_typing.try_again')}}
        </v-btn>
        <v-btn
          outline
          class="speed-typing__button"
          color="orange accent-3"
          v-on:click="saveResult"
        >
          {{$t('finish_test')}}
        </v-btn>
      </div>

      <!-- Random text field -->
      <div
        ref="text"
        class="speed-typing__text my-4 px-2 py-2"
        :class="{
          'speed-typing__text--success': isValidChar,
          'speed-typing__text--error': !isValidChar,
        }"
      >
        <span
          v-if="markedText && this.currentTimer > 0"
          class="speed-typing__text_countdown display-3 font-weight-light"
        >
          {{this.currentTimer}}
        </span>
        <span
          v-if="!generationProcess && !markedText"
          class="body-2 font-weight-light"
        >
          {{$t('speed_typing.placeholder')}}
        </span>
        <v-progress-circular
          v-if="generationProcess"
          :size="50"
          color="#AED581"
          indeterminate
        ></v-progress-circular>
        <span
          v-if="!generationProcess"
          class="speed-typing__text--monospace"
          :class="{'speed-typing__text--opacity': this.currentTimer > 0}"
          v-html="markedText"
        ></span>
      </div>

      <!-- Typing field -->
      <v-text-field
        spellcheck="false"
        ref="typing"
        color="success"
        v-model="typedText"
        v-on:keydown.prevent="typingHandler"
        :readonly="readonly"
        :maxLength="this.randomText.length"
        :error="!isValidChar"
        class="title font-weight-regular"
        loading
      >
        <template v-slot:progress>
          <v-progress-linear
            :value="progress"
            :color="color"
            height="5"
          ></v-progress-linear>
        </template>
      </v-text-field>

      <!-- Typing result -->
      <div class="speed-typing__result-wrap">
        <div class="speed-typing__result">
          <div class="speed-typing__result--speed">
            <v-icon x-large color="green lighten-1">alarm</v-icon>
            <div class="ml-3 display-3 font-weight-light">{{typingSpeed}} <span class="title">cpm</span></div>
          </div>
          <div class="speed-typing__result--accuracy">
            <v-icon x-large color="green lighten-1">error_outline</v-icon>
            <div class="ml-3 display-3 font-weight-light">{{typingAccuracy}} <span class="title">%</span></div>
          </div>
        </div>
      </div>

    </v-flex>
  </v-layout>
</template>

<script lang="ts">
import Vue from "vue";
import store from "@/store";
import statusCodes from "@/config/status-codes";

export default Vue.extend({
  name: "SpeedTyping",

  data() {
    return {
      randomText: "",
      markedText: "",
      typedText: "",
      startTime: 0,
      started: false,
      finished: true,
      currentAttempt: 0,
      attemptsNum: 3,
      textLength: 70,
      wordLength: 10,
      charsCount: 0,
      typingCount: 0,
      typingSpeed: 0,
      typingAccuracy: 0,
      typingResults: [] as Array<{
        accuracy: number,
        speed: number
      }>,
      isValidChar: true,
      readonly: true,
      generationProcess: false,
      currentTimer: 6,
      countdownTimer: null
    };
  },

  async beforeRouteEnter(to, from, next) {
    const examsList = store.state.general.examsList;

    if (!examsList.hasOwnProperty("typeSpeed")) {
      next("/");
    } else {
      try {
        if (examsList.typeSpeed.finished) {
          next("/");
        } else {
          if (!examsList.typeSpeed.started) {
            Vue.set(store.state.typing, "loading", true);
            await store.dispatch("typing/startTypingExam");
            Vue.set(examsList.typeSpeed, "started", true);
            Vue.set(store.state.typing, "loading", false);
          }

          next();
        }
      } catch (e) {
        Vue.set(store.state.typing, "loading", false);

        if (e.code === statusCodes.CONCURRENT_EXAM) {
          next("/");
        } else {
          Vue.set(store.state.general, "exception", true);
        }
      }
    }
  },

  computed: {
    progress(): number {
      return Math.round(this.charsCount * 100 / this.randomText.length);
    },
    color(): string {
      if (this.isValidChar) {
        return "success";
      }

      return "error";
    }
  },

  watch: {
    currentAttempt(attempt) {
      localStorage.typingAttempt = attempt;
    }
  },

  mounted() {
    if (localStorage.typingAttempt) {
      this.currentAttempt = localStorage.typingAttempt;
    }
  },

  methods: {
    async startTest() {
      this.currentAttempt++;
      this.generationProcess = true;

      try {
        await this.$store.dispatch("typing/getRandomText");
        this.randomText = this.$store.state.typing.randomText
          .substring(0, this.textLength)
          .replace(/\s$/, ".");
      } catch (e) {
        console.error(e);
        this.randomText = this.randomTextGenerator();
      }

      this.generationProcess = false;
      this.initData();
      this.runCountdownTimer();
    },

    finishTest() {
      this.finished = true;
      this.readonly = true;
      this.typingResults.push({
        speed: this.typingSpeed,
        accuracy: this.typingAccuracy
      });
    },

    randomTextGenerator() {
      const lettersUC = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");
      const lettersLC = "abcdefghijklmnoprstuvwxyz".split("");
      const digits = "0123456789".split("");
      const specialChars = "();:\",.&?!<>=-+*%$_".split("");

      const charsCategories = [
        lettersLC,
        lettersLC,
        lettersLC,
        lettersLC,
        lettersLC,
        lettersLC,
        lettersLC,
        lettersLC,
        lettersUC
        // digits,
        // specialChars
      ];

      let randomText = "";

      for (let i = 0; i < this.textLength; i++) {
        if (i > 0 && i % this.wordLength === 0) {
          randomText += " ";
        } else {
          const category = charsCategories[Math.floor(Math.random() * charsCategories.length)];
          randomText += category[Math.floor(Math.random() * category.length)];
        }
      }

      return randomText;
    },

    typingHandler(e) {
      const currentKey = e.key;

      if (!this.started || this.finished || currentKey.length !== 1) {
        return;
      }

      this.isValidChar = this.validate(currentKey);

      if (this.isValidChar) {
        this.typedText += currentKey;
        this.markedText = this.markText(++this.charsCount, "success");
      } else {
        this.markedText = this.markText(this.charsCount, "error");
      }

      this.typingCount++;
      this.calcResult();

      if (this.charsCount === this.randomText.length) {
        this.finishTest();
      }
    },

    markText(index, level) {
      if (index >= this.randomText.length) {
        return this.randomText;
      }

      const symbols = this.randomText.split("");
      symbols[index] = `<span class="mark--${level}">${symbols[index]}</span>`;
      return symbols.join("");
    },

    validate(key) {
      return key === this.randomText.charAt(this.charsCount);
    },

    calcResult() {
      const typingTime = ((new Date().getTime() - this.startTime) / 1000) / 60;
      const speed =  Math.round(this.charsCount / typingTime);

      this.typingSpeed = !speed || speed > 1000 ? this.typingSpeed : speed;
      this.typingAccuracy = Math.round(this.charsCount * 100 / this.typingCount);
    },

    async saveResult() {
      let speed = 0;
      let accuracy = 0;

      this.typingResults.forEach((result) => {
        if (result.speed > speed) {
          speed = result.speed;
          accuracy = result.accuracy;
        }
      });

      try {
        await this.$store.dispatch("typing/saveTypingResult", {speed, accuracy});
        Vue.set(this.$store.state.general.examsList.typeSpeed, "finished", true);
        Vue.set(this.$store.state.general.examsList.typeSpeed, "started", false);
        localStorage.clear();
        this.$router.push({name: "home"});
      } catch (e) {
        Vue.set(this.$store.state.general, "exception", true);
      }
    },

    runCountdownTimer() {
      if (--this.currentTimer > 0) {
        setTimeout(this.runCountdownTimer, 1000);
        return;
      }

      this.readonly = false;
      (this.$refs.typing as HTMLElement).focus();
      this.startTime = new Date().getTime();
      this.started = true;
    },

    initData() {
      this.markedText = this.markText(0, "success");
      this.typedText = "";
      this.started = false;
      this.finished = false;
      this.charsCount = 0;
      this.typingCount = 0;
      this.typingSpeed = 0;
      this.typingAccuracy = 0;
      this.startTime = 0;
      this.isValidChar = true;
      this.currentTimer = 6;
      this.readonly = true;
    }
  }
});
</script>

<style>
  .speed-typing__text {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    background-color: #ffffff;
    font-size: 20px;
    color: #444444;
    min-height: 90px;
  }

  .speed-typing__text--monospace {
    font-family: monospace;
  }

  .speed-typing__text--opacity {
    opacity: 0.2;
  }

  .speed-typing__text--success {
    border: 2px solid #4CAF50;
  }

  .speed-typing__text--error {
    border: 2px solid #FF5252;
  }

  .speed-typing__result-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .speed-typing__result {
    display: flex;
  }

  .speed-typing__result--speed,
  .speed-typing__result--accuracy {
    display: flex;
    align-items: center;
    margin: 30px;
  }

  .speed-typing__button {
    width: 200px;
  }

  .speed-typing__text_countdown {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .mark--success {
    background-color: #AED581;
    padding: 5px 0;

  }

  .mark--error {
    background-color: #FF5252;
    padding: 5px 0;
  }

</style>
