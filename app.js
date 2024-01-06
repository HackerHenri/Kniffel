import { createApp } from 'vue'
createApp({
    data() {
        return {
            rollCounter: 0,
            allDisabled: true,
            activePlayer: 0,
            player_name_1: 'Standard Player 1',
            player_name_2: 'Standard Player 2',
            buttonList: [
                {
                    id: 1,
                    locked: false,
                    value: 1
                },
                {
                    id: 2,
                    locked: false,
                    value: 2
                },
                {
                    id: 3,
                    locked: false,
                    value: 3
                },
                {
                    id: 4,
                    locked: false,
                    value: 4
                },
                {
                    id: 5,
                    locked: false,
                    value: 5
                }
            ],
            scoreList: [
                {
                    id: 1,
                    name: "1er",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 2,
                    name: "2er",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 3,
                    name: "3er",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 4,
                    name: "4er",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 5,
                    name: "5er",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 6,
                    name: "6er",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 7,
                    name: "Summe Oben",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 8,
                    name: "Bonus (63+)",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 9,
                    name: "Gesamt Oben",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 10,
                    name: "3er Pasch",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 11,
                    name: "4er Pasch",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 12,
                    name: "Full House",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 13,
                    name: "Kleine Straße",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 14,
                    name: "Große Straße",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 15,
                    name: "Kniffel",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 16,
                    name: "Chance",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 17,
                    name: "Gesamt Unten",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                },
                {
                    id: 18,
                    name: "Gesamt",
                    value: [0, 0],
                    locked: [false, true],
                    possible: [false, false]
                }

            ]
        }
    },
    methods: {

        async holdDice(id) {

            //deug code only
            // console.log(this.buttonList[id - 1].value)
            // end of debug code

            this.buttonList[id - 1].locked = !this.buttonList[id - 1].locked
            // send clicked button id to server, receive updated dice array
            try {
                const response = await axios.post('http://localhost/game.php', {
                    type: "diceLocked",
                    buttonId: id
                });
                // console.log(response.data);

                this.buttonList = response.data.dice
                this.rollCounter = response.data.rollCounter

            } catch (error) {
                console.error(error);
            }
        },

        async rollDices() {
            this.allDisabled = false

            if (this.rollCounter >= 3) {
                this.allDisabled = true
            }

            // send dice array to server
            try {
                const response = await axios.post('http://localhost/game.php', {
                    type: "rollDices",
                });
                // console.log(response.data);

                this.scoreList = response.data.scoreList
                this.activePlayer = response.data.activePlayer
                this.rollCounter = response.data.rollCounter
                this.buttonList = response.data.dice
                this.player_name_1 = response.data.player_name_1
                this.player_name_2 = response.data.player_name_2

                this.checkSpecialScore()

            } catch (error) {
                console.error(error);
            }
        },

        async selectResult(id) {

            // send clicked button id to server, receive complete updated round
            
            try {
                const response = await axios.post('http://localhost/game.php', {
                    type: "selectResult",
                    id: id,
                });
                // console.log(response.data);

                this.scoreList = response.data.scoreList
                this.activePlayer = response.data.activePlayer
                this.rollCounter = response.data.rollCounter
                this.buttonList = response.data.dice
                this.player_name_1 = response.data.player_name_1
                this.player_name_2 = response.data.player_name_2
                this.allDisabled = true

            } catch (error) {
                console.error(error);
            }
        },

        exitGame() {
            window.location.href = "index.html"
        },

        checkSpecialScore() {
            for (var i = 0; i < this.scoreList.length; i++) {
                this.scoreList[i].possible[0] = false
                this.scoreList[i].possible[1] = false
            }

            // check for special score buttons
            // for (var i = 0; i < 6; i++) {
            //
            //     if (this.scoreList[i].locked[this.activePlayer] == false) {
            //         this.scoreList[i].possible[this.activePlayer] = true
            //     }
            //     if (this.scoreList[i].locked[this.activePlayer] == false) {
            //         this.scoreList[i].possible[this.activePlayer] = true
            //     }
            // }
            if (this.scoreList[9].locked[this.activePlayer] == false && this.checkPasch(3)) {
                this.scoreList[9].possible[this.activePlayer] = true
            }
            if (this.scoreList[10].locked[this.activePlayer] == false && this.checkPasch(4)) {
                this.scoreList[10].possible[this.activePlayer] = true
            }
            if (this.scoreList[11].locked[this.activePlayer] == false && this.checkFullHouse()) {
                this.scoreList[11].possible[this.activePlayer] = true
            }
            if (this.scoreList[12].locked[this.activePlayer] == false && this.checkStreet(3)) {
                this.scoreList[12].possible[this.activePlayer] = true
            }
            if (this.scoreList[13].locked[this.activePlayer] == false && this.checkStreet(4)) {
                this.scoreList[13].possible[this.activePlayer] = true
            }
            if (this.scoreList[14].locked[this.activePlayer] == false && this.checkPasch(5)) {
                this.scoreList[14].possible[this.activePlayer] = true
            }
            // if (this.scoreList[15].locked[this.activePlayer] == false) {
            //     this.scoreList[15].possible[this.activePlayer] = true
            // }

        },

        checkNumberFrequency(number, freq) {
            var count = 0;
            for (var i = 0; i < this.buttonList.length; i++) {
                if (this.buttonList[i].value == number) {
                    count++;
                    if (count >= freq) {
                        return true;
                    }
                }
            }
            return false;
        },

        checkPasch(freq) {
            for (var i = 1; i <= 6; i++) {
                if (this.checkNumberFrequency(i, freq)) {
                    return true;
                }
            }
            return false;
        },

        checkFullHouse() {
            var counter = 0;
            var counter2 = 0;
            for (var i = 0; i < this.buttonList.length; i++) {
                if (this.checkNumberFrequency(this.buttonList[i].value, 3)) {
                    counter++;
                }
                else if (this.checkNumberFrequency(this.buttonList[i].value, 2)) {
                    counter2++;
                }
                else {
                    return false;
                }
            }
            if ((counter > 0) && (counter2 > 0)) {
                // console.log("Full House");
                return true;

            }
            else {
                return false;
            }
        },

        checkStreet(n) {
            // für n = 3: 1,2,3,4 oder 2,3,4,5 oder 3,4,5,6
            // für n = 4: 1,2,3,4,5 oder 2,3,4,5,6
            var diceScore_sort = [0, 0, 0, 0, 0]
            for (var i = 0; i < this.buttonList.length; i++) {
                diceScore_sort[i] = this.buttonList[i].value;
            }
            var diceScore_sort = diceScore_sort.sort();
            var counter = 0;
            for (var i = 0; i < diceScore_sort.length; i++) {
                if (diceScore_sort[i] == diceScore_sort[i + 1] - 1) {
                    counter++;
                }
            }
            if (counter >= n) {
                // console.log(n + "er " + "Street");
                return true;
            }
            else {
                return false;
            }
        }
    },

    async mounted() {
        // this function gets called when the page is loaded
        // get game state from server and update js variables
        try {
            const response = await axios.post('http://localhost/game.php', {
                type: "sendGameState",
            });
            // console.log(response.data);

            this.scoreList = response.data.scoreList
            this.activePlayer = response.data.activePlayer
            this.rollCounter = response.data.rollCounter
            this.buttonList = response.data.dice
            this.player_name_1 = response.data.player_name_1
            this.player_name_2 = response.data.player_name_2

            if(this.rollCounter == 0){
                this.allDisabled = true
            }
            else{
                this.allDisabled = false
                this.checkSpecialScore()
            }


        } catch (error) {
            console.error(error);
        }

    }
}).mount('#app')