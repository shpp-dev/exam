<template>
  <div class="exam__select">
    <router-link
        v-for="(exam, type) in exams"
        :key="type"
        :to="{name: type}"
        class="exam__select--button"
        :class="{'not-allowed': exam.finished || !exam.allowed}"
    >
      <v-card style="height: 100%">
        <div :id="`${type}-test`" style="height: 100%">
          <span class="exam__select--label">{{type}}</span>
        </div>
        <v-btn
            v-if="exam.finished"
            absolute
            dark
            fab
            top
            right
            small
            color="green"
        >
          <v-icon>check</v-icon>
        </v-btn>
        <v-progress-linear
            v-if="type === 'programming' && programmingLoading"
            color="green"
            background-color="none"
            :indeterminate="true"
        ></v-progress-linear>
        <v-progress-linear
            v-if="type === 'english' && englishLoading"
            color="green"
            background-color="none"
            :indeterminate="true"
        ></v-progress-linear>
      </v-card>
    </router-link>
    <v-dialog v-model="examFinished" width="500">
      <FinishForm></FinishForm>
    </v-dialog>
  </div>
</template>


<script lang="ts">
import Vue from "vue";
import FinishForm from "@/components/FinishForm.vue";

export default Vue.extend({
    name: "Home",
    components: {
      FinishForm
    },

    data() {
        return {
            logout: false,
            comment: ""
        };
    },

    computed: {
        exams(): {} {
            const examsList = this.$store.state.general.examsList;
            examsList.programming.allowed = !examsList.english.started && !examsList.typeSpeed.started;
            examsList.english.allowed = !examsList.programming.started && !examsList.typeSpeed.started;
            examsList.typeSpeed.allowed = !examsList.programming.started && !examsList.english.started;

            return examsList;
        },
        programmingLoading(): boolean {
            return this.$store.state.programming.loading;
        },
        englishLoading(): boolean {
            return this.$store.state.english.loading;
        },
        typingLoading(): boolean {
            return this.$store.state.typing.loading;
        },
        examFinished(): boolean {
            const examFinished = this.$store.state.general.examFinished;
            if (examFinished) {
                this.logout = true;
            }
            return examFinished;
        }
    },

    watch: {
        logout() {
            this.$store.dispatch("general/logout");
        }
    },
    methods: {
        sendComment() {
            console.log(this.comment);
        }
    }
});
</script>

<style lang="scss">
  .exam__select {
    display: flex;
    justify-content: space-evenly;
    font-family: 'ZX', serif !important;

    .exam__select--button {
      height: 270px;
      width: 20%;

      &.not-allowed {
        pointer-events: none;
      }
    }

    [id*=test] {
      position: relative;
      background-repeat: no-repeat;
      background-position: center 40px;
      background-size: 150px;
    }

    .not-allowed [id*=test] {
      filter: grayscale(1)
    }

    .exam__select--label {
      position: absolute;
      bottom: 20px;
      left: 0;
      text-align: center;
      right: 0;
      font-size: 20px;
      font-weight: bold;
      color: white;
    }
  }

  #programming-test {
    background-image: url('../assets/images/code.png');
  }

  #english-test {
    background-image: url('../assets/images/gb.png');
  }

  #typeSpeed-test {
    background-image: url('../assets/images/type.png');
  }
</style>
