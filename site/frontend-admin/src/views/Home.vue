<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <div class="home">
    <v-card>
      <v-container class="home-container">
        <v-layout row justify-space-between>
          <v-flex xs2>
            <v-select
              v-model="selected"
              :items="statuses"
              label="Показать экзамены"
              v-on:change="getExamsList"
            ></v-select>
          </v-flex>
          <v-flex xs5>
            <v-card>
              <h3 class="text-sm-center pt-3 pb-2 body-1 font-weight-regular blue-grey lighten-4">Идентификационные куки</h3>
              <v-expansion-panel
                expand
              >
                <v-expansion-panel-content v-for="location in locations">
                  <template v-slot:header>
                    <span>{{location.address}}</span>
                  </template>
                  <v-card>
                    <v-card-actions v-for="clientId in location.clientsIds">
                      <v-btn small block color="primary" @click.stop="saveEverCookie(location.id, location.address, clientId)">Установить для устройства №{{clientId}}</v-btn>
                      <v-btn small block color="primary" @click.stop="removeEverCookie">Удалить для устройства №{{clientId}}</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-expansion-panel-content>
              </v-expansion-panel>

              <h3 class="text-sm-center pt-3 pb-2 body-1 font-weight-regular blue-grey lighten-4">Отключить проверкку локации для пользователя</h3>
              <v-form
                ref="disableCheckingLocation"
                v-model="emailValid"
                class="px-4"
                @submit.prevent="disableCheckingLocation"
              >
                <v-text-field
                  v-model="email"
                  :rules="emailRules"
                  label="E-mail"
                  required
                ></v-text-field>
                <v-flex class="text-xs-center">
                  <v-btn
                    small
                    color="primary"
                    @click="disableCheckingLocation"
                  >
                    Отключить проверку локации
                  </v-btn>
                </v-flex>
              </v-form>
            </v-card>
          </v-flex>
        </v-layout>
        <v-dialog v-model="dialogLocation" max-width="300">
          <v-card>
            <v-card-text class="text-xs-center">
              {{dialogLocationMessage}}
            </v-card-text>
            <v-card-actions class="align-content-center">
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" flat="flat" v-on:click="dialogLocation = false">OK</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-container>

      <v-container class="home-container">
        <v-data-table
          :headers="headers"
          :items="exams"
          :pagination.sync="pagination"
        >
          <template slot="items" slot-scope="props">
            <tr v-bind:class="{'exam-success': props.item.passed === 1, 'exam-fail': props.item.passed === 0}">
              <td class="text-xs-center px-0">{{props.item.sessionId}}</td>
              <td class="text-xs-center px-0"><a :href=getAccountUrl(props.item.accountId)>{{props.item.accountId}}</a></td>

              <td class="text-xs-left px-0">
                Старт: {{new Date(props.item.timing.startedAtTs).toLocaleString("en-GB").slice(0, -3)}} <br>
                Финиш: {{new Date(props.item.timing.finishedAtTs).toLocaleString("en-GB").slice(0, -3)}}
              </td>

              <td class="text-xs-center px-0 py-2">
                <div v-for="programming in props.item.programming">
                  <ProgrammingCollapse :programming-data="programming" ></ProgrammingCollapse>
                </div>
              </td>

              <td class="text-xs-center px-0">
                {{props.item.english.score}} / {{props.item.english.answers}}
              </td>

              <td class="text-xs-left px-0">
                Скорость: {{props.item.typeSpeed.speed}} <br>
                Точность: {{props.item.typeSpeed.accuracy}}
              </td>

              <td class="text-xs-center px-0">
                <span v-if="props.item.passed === null">Ожидает проверки</span>
                <span v-if="props.item.passed === 0">Провален</span>
                <span v-if="props.item.passed === 1">Успешно пройден</span>
              </td>

              <td class="text-xs-center px-0">
                <div v-if="props.item.passed === null">
                  <v-dialog v-model="dialogAccept[props.item.sessionId]" max-width="300">
                    <template v-slot:activator="{on}">
                      <v-btn class="action-btn" block top small color="success" v-on="on">Принять</v-btn>
                    </template>
                    <v-card>
                      <v-card-text class="text-xs-center">
                        Вы уверены в своем выборе?
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" flat="flat" v-on:click="closeDialog">Нет</v-btn>
                        <v-btn color="green darken-1" flat="flat" v-on:click="checkExam(props.item.sessionId, true)">Да</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>

                  <v-dialog v-model="dialogDecline[props.item.sessionId]" max-width="300">
                    <template v-slot:activator="{on}">
                      <v-btn class="action-btn" block small color="error" v-on="on">Отклонить</v-btn>
                    </template>
                    <v-card>
                      <v-card-text class="text-xs-center">
                        Вы уверены в своем выборе?
                      </v-card-text>
                      <v-card-actions class="align-content-center">
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" flat="flat" v-on:click="closeDialog">Нет</v-btn>
                        <v-btn color="green darken-1" flat="flat" v-on:click="checkExam(props.item.sessionId, false)">Да</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </div>
              </td>
            </tr>
          </template>
        </v-data-table>
      </v-container>
    </v-card>
  </div>
</template>

<script>
import Vue from "vue";
import ProgrammingCollapse from "@/components/ProgrammingCollapse.vue";
import config from "@/config/locations";
import {urls} from "@/config";

export default Vue.extend({
  name: "home",
  components: {
    ProgrammingCollapse
  },

  data() {
    return {
      dialogAccept: [],
      dialogDecline: [],
      dialogLocation: false,
      dialogLocationMessage: '',

      locations: config.locations,

      statuses: [
        {value: "all", text: "все"},
        {value: "unchecked", text: "ожидают проверки"},
        {value: "passed", text: "успешно пройденные"},
        {value: "failed", text: "проваленные"}
      ],

      headers: [
        {value: "sessionId", text: "#", align: "center"},
        {value: "accountId", text: "Профиль", align: "center", sortable: false},
        {value: "timing", text: "Время", sortable: false, align: "center"},
        {value: "programming", text: "Программирование", sortable: false, align: "center", width: "40%"},
        {value: "english", text: "Английский", align: "center", sortable: false},
        {value: "typeSpeed", text: "Набор", align: "center", sortable: false},
        {value: "status", text: "Статус", align: "center", sortable: false, width: "5%"},
        {value: "action", text: "Действие", sortable: false, align: "center", width: "10%"}
      ],

      pagination: {
        descending: true,
        sortBy: "sessionId"
      },

      emailValid: true,
      email: '',
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ]
    };
  },

  computed: {
    selected() {
      return this.$store.state.exams.selected;
    },

    exams() {
      return this.$store.state.exams.list;
    }
  },

  methods: {
    async saveEverCookie(locationId, locationAddress, clientId) {
      const token = await this.getRandomString();

      await this.$store.dispatch("client/saveEverCookie", {
          locationId: locationId,
          locationAddress: locationAddress,
          clientId: clientId,
          token: token
      });

      this.showDialogLocation('Идентификационная кука сохранена');
    },

    async removeEverCookie() {
      await this.$store.dispatch("client/removeEverCookie");
      this.showDialogLocation('Идентификационная кука удалена');
    },

    async disableCheckingLocation() {
      if (this.emailValid) {
        this.showDialogLocation('Проверка локации для юзера ' + this.email + ' отключена');
        try {
          await this.$store.dispatch("client/disableCheckingLocation", {
            email: this.email
          });
          this.showDialogLocation('Проверка локации для пользователя ' + this.email + ' отключена');
        } catch (e) {
          if (e.code === 404) {
            this.showDialogLocation('Пользователь ' + this.email + ' не найден');
          } else {
            this.showDialogLocation('Упс, что-то пошло не так...');
          }
        }
      }
    },

    async getExamsList(status) {
      await this.$store.dispatch("exams/getExams", {key: status});
    },

    async checkExam(session, passed) {
      this.closeDialog();

      await this.$store.dispatch("exams/checkExam", {
        status: this.selected,
        result: {
          sessionId: session,
          passed
        }
      });
    },

    closeDialog() {
      this.dialogAccept = [];
      this.dialogDecline = [];
    },

    showDialogLocation(message) {
      this.dialogLocationMessage = message;
      this.dialogLocation = true;
    },

    getRandomString() {
      const possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      const length = 20;
      let randomString = "";

      for (let i = 0; i < length; i++) {
        randomString += possible.charAt(Math.floor(Math.random() * possible.length));
      }

      return randomString;
    },

    getAccountUrl(accountId) {
        return urls.userProfile + '/' + accountId;
    }
  }
});
</script>

<style>
  .exam-success {
    background-color: #A9F5BC;
  }

  .exam-fail {
    background-color: #FA8258;
  }

  .home-container {
    max-width: 100%;
  }
</style>
