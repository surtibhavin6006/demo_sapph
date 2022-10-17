<template>
    <main>
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <router-link :to="{name:'dashboard'}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                    <span class="fs-4">Saphhire Demo</span>
                </router-link>
            </header>
            <div class="row">

                <ul class="nav nav-tabs">
                    <li v-for="tab in tabs" class="nav-item">
                        <a :class="[tab.current ? 'active' : '','nav-link']" href="#" :key="tab.id">{{tab.title}}</a>
                    </li>
                </ul>

                <div :class="['container mt-5']">
                    <div :class="[tabsDisplay.create_a_team ? 'd-block' : 'd-none']">
                        <div class="row mb-3">
                            <div :class="[step1.is_error ? 'alert alert-danger' : 'd-none']" role="alert" >
                                {{ step1.error_message_on_team_save ? step1.error_message_on_team_save : 'Please enter team name.' }}
                            </div>
                            <div :class="[step1.is_team_saved ? 'alert alert-success' : 'd-none']" role="alert" >
                                {{ step1.save_message }}
                            </div>
                            <div class="col-4">
                                <label for="exampleFormControlInput1" class="form-label">Add team name</label>
                                <input v-model="step1.team_name" placeholder="team name" v-on:keyup.enter="saveTeam" />
                            </div>
                            <div class="col-4">
                                <button @click="saveTeam()">Save</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <li v-for="team in teams" :key="team.id" :class="['list-group-item']">
                                        <label :for="'label_'+team.id"> {{team.name}}</label>
                                </li>
                            </div>
                        </div>
                    </div>

                    <div :class="[tabsDisplay.select_four_winner ? 'd-block' : 'd-none']">
                        <div :class="[step2.is_error ? 'alert alert-danger' : 'd-none']" role="alert" >
                            {{ step2.error_message_on_team_save ? step2.error_message_on_team_save : 'Please select 4 teams' }}
                        </div>
                        <ul class="list-group">
                            <li v-for="team in teams" :key="team.id" :class="['list-group-item']">
                                <input
                                    type="checkbox"
                                    :id="'label_step2_'+team.id"
                                    :value="team.id"
                                    v-model="step2.checkedWinnerStep2"
                                    :disabled="step2.checkedWinnerStep2.length >= 4 && step2.checkedWinnerStep2.indexOf(team.id) === -1"
                                />
                                <label :for="'label_step2_'+team.id"> {{team.name}}</label>
                            </li>
                        </ul>
                        <div class="col-4">
                            <button @click="saveWinnerTeamStep2()">Next</button>
                        </div>
                    </div>

                    <div :class="[tabsDisplay.select_two_winner ? 'd-block' : 'd-none']">
                        <div :class="[step3.is_error ? 'alert alert-danger' : 'd-none']" role="alert" >
                            {{ step3.error_message_on_team_save ? step3.error_message_on_team_save : 'Please select 2 teams' }}
                        </div>

                        <ul class="list-group">
                            <li v-for="team in teams" :key="team.id" :class="[(team.is_winner === 0) ? 'd-none' : 'list-group-item']" >
                                <input
                                    type="checkbox"
                                    :id="'label_step3_'+team.id"
                                    :value="team.id"
                                    v-model="step3.checkedWinnerStep3"
                                    :disabled="step3.checkedWinnerStep3.length >= 4 && step3.checkedWinnerStep3.indexOf(team.id) === -1"
                                />
                                <label :for="'label_step3_'+team.id"> {{team.name}}</label>
                            </li>
                        </ul>
                        <div class="col-4">
                            <button @click="saveWinnerTeamStep3()">Next</button>
                        </div>
                    </div>


                    <div :class="[tabsDisplay.select_final_winner ? 'd-block' : 'd-none']">
                        <div :class="[step4.is_error ? 'alert alert-danger' : 'd-none']" role="alert" >
                            {{ step4.error_message_on_team_save ? step4.error_message_on_team_save : 'Please select a team' }}
                        </div>

                        <ul class="list-group">
                            <li v-for="team in teams" :key="team.id" :class="[(team.is_winner === 0) ? 'd-none' : 'list-group-item']" >
                                <input
                                    type="checkbox"
                                    :id="'label_step4_'+team.id"
                                    :value="team.id"
                                    v-model="step4.checkedWinnerStep4"
                                    :disabled="step4.checkedWinnerStep4.length >= 4 && step4.checkedWinnerStep4.indexOf(team.id) === -1"
                                />
                                <label :for="'label_step4_'+team.id"> {{team.name}}</label>
                            </li>
                        </ul>
                        <div class="col-4">
                            <button @click="saveAWinnerTeamStep4()">Next</button>
                        </div>
                    </div>

                    <div :class="[tabsDisplay.final_winner ? 'd-block' : 'd-none']">
                        <ul class="list-group">
                            <div v-for="team in teams" :key="team.id" :class="[(team.is_winner === 0) ? 'd-none' : 'list-group-item']" >
                                <label> {{team.name}}</label>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import {ref} from "vue";
import axios from 'axios';

export default {
    name: "DashboardPage",
    setup() {
        const tabs = ref([
            {id:1, title: '1) Create a team', name: 'create_a_team',href: '#create_a_team', current: true},
            {id:2, title: '2) Select 4 Winner', name: 'select_four_winner',href: '#select_four_Winner', current: false},
            {id:3, title: '3) Select 2 Winner', name: 'select_two_winner',href: '#select_two_Winner', current: false},
            {id:3, title: '4) Select Winner', name: 'select_final_winner',href: '#select_final_winner', current: false},
            {id:3, title: '5) Winner', name: 'final_winner',href: '#final_winner', current: false},
        ]);

        const tabsDisplay = {
            create_a_team:false,
            select_four_winner:false,
            select_two_winner:false,
            select_final_winner:false,
            final_winner:false
        }

        // expose to template and other options API hooks
        return {
            tabs,
            tabsDisplay
        }
    },
    data() {
        return {
            teams :  [],
            checkedWinnerStep4 : [],
            step1 : {
                is_team_saved : false,
                save_message : 'Saved!!',
                team_name : '',
                is_error : false,
                error_message : false
            },
            step2 : {
                is_team_update : false,
                update_message : false,
                checkedWinnerStep2 : [],
                is_error : false,
                error_message : false,
            },
            step3 : {
                checkedWinnerStep3 : [],
                is_error : false,
                error_message : false,
            },
            step4 : {
                checkedWinnerStep4 : [],
                is_error : false,
                error_message : false,
            }
        }
    },
    created() {
        this.getAllTeams();
    },
    methods: {
        async getAllTeams() {
            await axios.get('/api/team').then(res => {
                this.teams = res.data.data;
                this.changeTabOnTeamModified();
            });
        },
        changeTabOnClick(tabName) {
          this.tabs.map((tab,index) => {
              tab.current = false;
              this.tabsDisplay[tab.name] = false;
              if(tab.name === tabName){
                  tab.current = true;
                  this.tabsDisplay[tabName] = true;
              }
          });
          console.log(this.tabsDisplay[tabName],tabName);
        },
        changeTabOnTeamModified() {
            let step2Count = 0;
            let step3Count = 0;
            let step4Count = 0;
            this.teams.forEach((data,index) => {
                if(data.is_winner === 1 && data.step_on_which_is_winner_updated === 2){
                    step2Count++;
                    this.step2.checkedWinnerStep2.push(data.id);
                }

                if(data.is_winner === 1 && data.step_on_which_is_winner_updated === 3){
                    step3Count++;
                    this.step3.checkedWinnerStep3.push(data.id);
                }

                if(data.is_winner === 1 && data.step_on_which_is_winner_updated === 4){
                    step4Count++;
                    this.step4.checkedWinnerStep4.push(data.id);
                }
            });

            if(this.teams.length >= 8) {
                if (step4Count === 1) {
                    // todo
                    this.displayWinner();
                } else if (step3Count === 2) {
                    // show step 4 to select a winner
                    this.selectAWinnerSetup();
                } else if (step2Count === 4) {
                    // show step 3 to select 2 winner
                    this.selectTwoWinnerSetup();
                } else {
                    // show step 2 to select 4 winner
                    this.selectFourWinnerSetup();
                }
            } else {
                this.changeTabOnClick('create_a_team');
            }
        },
        async saveTeam() {
            if(this.step1.team_name === ''){
                this.step1.is_error = true;
                return;
            }
            this.step1.is_error = false;
            let data = {
                name: this.step1.team_name
            }
            await axios.post('/api/team',data).then(res => {
                this.getAllTeams();
                this.step1.team_name = '';
                this.step1.is_team_saved = true;
            }).catch(error => {
                this.step1.error_message_on_team_save = error.response.data.message;
                this.step1.is_error = true;
            });
        },
        async saveWinnerTeamStep2() {
            if(this.step2.checkedWinnerStep2.length !== 4){
                this.step2.is_error = true;
                return;
            }
            this.step2.is_error = false;
            let data = {
                winner_ids: this.step2.checkedWinnerStep2
            }
            await axios.post('/api/team/winner-step/2',data).then(res => {
                this.teams = res.data.data;
                this.selectTwoWinnerSetup()
            }).catch(error => {
                this.step2.error_message = error.response.data.message;
                this.step2.is_error = true;
            });
        },
        async saveWinnerTeamStep3() {
            if(this.step3.checkedWinnerStep3.length  !== 2){
                this.step3.is_error = true;
                return;
            }
            this.step3.is_error = false;
            let data = {
                winner_ids: this.step3.checkedWinnerStep3
            }
            await axios.post('/api/team/winner-step/3',data).then(res => {
                this.teams = res.data.data;
                this.selectAWinnerSetup()
            }).catch(error => {
                this.step3.error_message = error.response.data.message;
                this.step3.is_error = true;
            });
        },
        async saveAWinnerTeamStep4() {
            if(this.step4.checkedWinnerStep4.length  !== 1){
                this.step4.is_error = true;
                return;
            }
            this.step4.is_error = false;
            let data = {
                winner_ids: this.step4.checkedWinnerStep4
            }
            await axios.post('/api/team/winner-step/4',data).then(res => {
                this.teams = res.data.data;
                this.displayWinner()
            }).catch(error => {
                this.step4.error_message = error.response.data.message;
                this.step4.is_error = true;
            });
        },
        selectFourWinnerSetup() {
            this.changeTabOnClick('select_four_winner');
            this.step2.checkedWinnerStep2 = this.selectRandomDataForStep(4);
        },
        selectTwoWinnerSetup() {
            this.changeTabOnClick('select_two_winner');
            this.step3.checkedWinnerStep3 = this.selectRandomDataForStep(2)
        },
        selectAWinnerSetup() {
            this.changeTabOnClick('select_final_winner');
            this.step4.checkedWinnerStep4 = this.selectRandomDataForStep(1)
        },
        displayWinner() {
            this.changeTabOnClick('final_winner');
        },
        selectRandomDataForStep(randElements) {
            let ids = [];
            this.teams.forEach((data,index) => {
                if(data.is_winner === null || data.is_winner === 1){
                    ids.push(data.id);
                }
            });
            console.log(ids);
            return this.getMultipleRandom(ids,randElements);
        },
        getMultipleRandom(arr, num) {
            const shuffled = [...arr].sort(() => 0.5 - Math.random());

            return shuffled.slice(0, num);
        }
    }
}
</script>

<style scoped>
</style>
