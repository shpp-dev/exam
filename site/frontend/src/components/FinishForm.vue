<template>
  <v-layout>
    <v-flex>
      <v-card light>
        <v-card-text class="form__window">
          <strong class="body-1 mb-3">{{$t('home.well_done')}}</strong>
          <strong class="body-1 mb-3">{{$t('home.before_exit')}}</strong>
          <v-divider width="20%" class="mb-3"></v-divider>

          <strong v-if="zeroStatus == 0" class="subheading">{{$t('zero_status.question1')}}</strong>
          <div class="form__radio" v-if="zeroStatus == 0">
            <v-radio-group v-model="zeroStatus" column>
              <v-radio
                class="radio"
                :label="$t('zero_status.yes')"
                value="1"
                color="orange darken-3"
              ></v-radio>
              <v-radio
                :label="$t('zero_status.no')"
                value="0"
                color="orange darken-3"
              ></v-radio>
            </v-radio-group>
          </div>

          <strong v-if="zeroStatus > 0" class="subheading">{{$t('zero_status.question2')}}</strong>
          <div class="form__radio" v-if="zeroStatus > 0">
            <v-rating
              v-model="zeroStatus"
              length="10"
              color="orange darken-3"
            ></v-rating>
          </div>

          <v-btn
            :loading="loading"
            outline
            @click="saveZeroStatus"
            color="success"
          >
            {{$t('send_answer')}}
          </v-btn>

        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script lang="ts">
import Vue from "vue";

export default Vue.extend({
  name: "FinishForm",

  data() {
    return {
      zeroStatus: "0",
      loading: false
    };
  },

  methods: {
    async saveZeroStatus() {
      this.loading = true;
      await this.$store.dispatch("general/saveZeroStatus", {
        zeroStatus: this.zeroStatus
      });
    }
  }
});
</script>

<style scoped>
  .form__window {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .form__radio {
    min-height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .subheading {
    text-align: center;
  }

</style>
