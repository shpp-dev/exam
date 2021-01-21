<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <v-card v-on="$listeners" class="programming-block">
    <div v-on:click="toggle" class="programming-header">
      <div>
        <v-tooltip top max-width="500">
          <template v-slot:activator="{on}">
            <v-icon small dark color="blue" v-on="on">info</v-icon>
          </template>
          <span class="programming-task-description">
            <span><b>Задание: </b>{{programmingData.task.description.problem}}<br></span>
            <span v-if="programmingData.task.description.note"><b>Примечание: </b>{{programmingData.task.description.note}}<br></span>
            <span v-if="programmingData.task.description.example"><b>Пример :</b><br>
              input: {{programmingData.task.description.example.input}}<br>
              output: {{programmingData.task.description.example.output}}
            </span>
          </span>
        </v-tooltip>
        <span class="programming-task-number">Задание {{programmingData.task.number}}: {{programmingData.task.name}}</span>
      </div>

      <div>
        <div v-for="result in programmingData.solution.caseResults">
          <v-icon dark small color="green" v-if="result">check_circle</v-icon>
          <v-icon small color="red" v-else>remove_circle</v-icon>
        </div>
      </div>
    </div>
    <div class="programming-solution" v-if="isVisible">
      <pre>{{programmingData.solution.userFunction}}</pre>
    </div>
  </v-card>
</template>

<script>
  export default {
    props: ["programmingData"],
    name: "ProgrammingCollapse",
    data() {
      return {
        isVisible: false
      };
    },
    methods: {
      toggle() {
        this.isVisible = !this.isVisible;
      }
    }
  };
</script>

<style scoped>
  .programming-block {
    margin: 5px 0;
    padding: 5px 10px;
    border: 1px solid #000;
    position: relative;
  }

  .programming-header {
    cursor: pointer;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .programming-header > div {
    display: flex;
    flex-direction: row;
  }

  .programming-solution {
    margin-top: 5px;
    padding: 5px 0;
    border-top: 1px solid #000;
    text-align: left;
  }

  .programming-task-number {
    font-weight: 400;
    margin-left: 5px;
  }
</style>
