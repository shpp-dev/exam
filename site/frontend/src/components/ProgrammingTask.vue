<template>
  <v-layout class="ma-3">
    <v-flex xs6>
      <v-card dark class="programming__task-block mx-2">
        <h3 class="pa-2 subheading text-xs-center orange--text">{{task.number}}. {{task.name}}</h3>
        <v-divider class="mx-2"></v-divider>
        <div class="mx-3 my-2" v-if="task.number">
          <p>
            <span class="font-weight-medium green--text text--lighten-1">{{$t('task')}}: </span>
            <span>{{task.description.problem}}</span><br>
            <span v-if="task.description.note">{{task.description.note}}</span>
          </p>
          <p>
            <span class="font-weight-medium green--text text--lighten-1">{{$t('programming.example')}}:</span><br>
            <span class="pink--text">{{$t('programming.input')}}:</span> {{task.description.example.input}}<br>
            <span class="pink--text">{{$t('programming.output')}}:</span> {{task.description.example.output}}<br>
          </p>
        </div>
        <div class="mx-3 my-2" v-else>
          <p>{{$t('programming.task0.title')}}</p>
          <p>
            <span class="font-weight-medium green--text text--lighten-1">{{$t('task')}}: </span>
            <span>{{$t('programming.task0.task')}}</span>
          </p>
          <p>
            <span class="font-weight-medium green--text text--lighten-1">{{$t('programming.note')}}: </span>
            {{$t('programming.task0.note1')}}
            <a class="orange--text" @click="showLibrary = true">{{$t('programming.task0.here')}}</a>.
          </p>
          <div class="programming__info">
            <v-icon class="mr-1" color="pink">error_outline</v-icon>
            <span>{{$t('programming.task0.note2')}}</span>
          </div>
        </div>
      </v-card>
    </v-flex>

    <v-flex xs6>
      <v-card class="programming__code-block mx-2">
        <v-btn-toggle v-model="programmingLang" mandatory>
          <v-flex xs4>
            <v-btn class="programming__lang-btn" @click="setMode('js')" value="js">
              javascript
            </v-btn>
          </v-flex>
          <v-flex xs4>
            <v-btn class="programming__lang-btn" @click="setMode('java')" value="java">
              java
            </v-btn>
          </v-flex>
          <v-flex xs4>
            <v-btn class="programming__lang-btn" @click="setMode('cpp')" value="cpp">
              c++
            </v-btn>
          </v-flex>
        </v-btn-toggle>
      <codemirror
        ref="codeMirror"
        v-model="userFunction"
        @input="changeFunction"
        :options="cmOptions"
      ></codemirror>
      </v-card>
    </v-flex>

    <div>
      <v-dialog light v-model="showLibrary" width="500">
        <v-card>
          <v-card-text class="text-xs-center pb-0">
            <h4>{{$t('programming.libs.title')}}</h4>
          </v-card-text>
          <v-card-text>
            <p>
              {{$t('programming.libs.p')}}
            </p><h5>Java</h5>
            <ul>
              <li>import java.util.Scanner;</li>
              <li>import java.lang.String;</li>
              <li>import java.lang.Math;</li>
            </ul>
            <h5>C++</h5>
            <ul>
              <li>#include &lt;iostream&gt;</li>
              <li>#include &lt;cmath&gt;</li>
              <li>#include &lt;string&gt;</li>
              <li>using namespace std;</li>
            </ul>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="success"
              flat
              @click="showLibrary = false"
            >
              {{$t('ok')}}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div>
  </v-layout>
</template>

<script lang="ts">
import Vue from "vue";
import { codemirror } from "vue-codemirror";
import "codemirror/lib/codemirror.css";
import "codemirror/mode/javascript/javascript.js";
import "codemirror/mode/clike/clike.js";
import "codemirror/theme/base16-dark.css";
import "codemirror/theme/monokai.css";

export default Vue.extend({
  name: "ProgrammingTask",
  components: {codemirror},
  props: ["task", "lang"],
  data() {
    return {
      userFunction: this.task.functionStart[this.lang],
      programmingLang: this.lang,
      showLibrary: false,
      cmOptions: {
        tabSize: 4,
        mode: "text/javascript",
        theme: "monokai",
        lineNumbers: true,
        line: true
      }
    };
  },

  watch: {
    task() {
      this.programmingLang = this.lang;
      this.userFunction = this.task.functionStart[this.lang];
    }
  },

  methods: {
    setMode(lang) {
      switch (lang) {
        case "js":
          Vue.set(this.cmOptions, "mode", "text/javascript");
          break;
        case "java":
          Vue.set(this.cmOptions, "mode", "text/x-java");
          break;
        case "cpp":
          Vue.set(this.cmOptions, "mode", "text/x-c++src");
          break;
      }

      this.programmingLang = lang;
      this.userFunction = this.task.functionStart[lang];
    },

    changeFunction() {
      this.$set(this.task.functionStart, this.programmingLang, this.userFunction);

      this.$emit("changeFunction", {
        lang: this.programmingLang,
        taskNumber: this.task.number,
        userFunction: this.userFunction
      });
    }
  }
});
</script>

<style>
  a {
    color: orange;
  }

  .programming__code-block {
    background-color: #272822;
    display:flex;
    flex-direction: column;
    justify-content: center;
  }

  .programming__task-block {
    height: 100%;
    overflow-y: auto;
  }

  .programming__lang-btn {
    width: 100% !important;
  }

  .programming__info {
    display: flex;
    align-items: center;
  }

</style>
