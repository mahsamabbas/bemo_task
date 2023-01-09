<template>
    <div class="">
        <div class="nav">
            <ul class="nav__list">
                <li class="nav__item"><a class="nav__link" href="#">Templates</a></li>
                <li class="nav__item">
                    <a class="nav__link active" href="/db-dump" target="_blank">Db Dump</a>
                </li>
            </ul>
            <div class="search__bar">
                <i class="fas fa-search"></i>
                <input class="nav__search" type="text" placeholder="Search" />
            </div>
        </div>

        <section>
            <div class="list__title">
                <h3>Front End Questionaires</h3>
            </div>
        </section>

        <section>
            <div class="todo-cards">
                <draggable class="d-inline-block" element="div" @end="changeColumnOrder" v-model="columns" :options="dragOptions">
                    <transition-group class="row">
                        <div class="todo-cards__wrapper" v-for="(column,column_index) in columns" :key="column.id" :id="column.id">
                            <div class="todo-cards__card">
                                <div class="todo-cards__card-header">
                                    <div class="todo-box__item">
                                        <div class="todo-box__item-text" v-if="column === editingColumn">
                                            <input type="text" class="text-input"
                                                   @keyup.enter="endEditingColumn(column)" @blur="endEditingColumn(column)" v-model="column.title"
                                            >
                                        </div>

                                        <div v-else class="todo-box__item-text" @click="editColumn(column)">
                                            {{ column.title }}
                                        </div>

                                        <div class="close-icon" @click="deleteColumn(column, column_index)">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                    <draggable :options="dragOptions" element="div" @end="changeCardOrder" :list="column.cards" group="my-group" class="todo-box__car-wrap">
                                        <transition-group class="card--holder" :id="column.id">
                                            <div v-for="card in column.cards" :key="card.column_id+','+card.order" :id="card.id">
                                                <div class="todo-sample__card transit-1" v-if="card !== editingCard" @click="openCardModal(card)">
                                                    <div class="pencil-icon" @click="editCard(card)">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </div>
                                                    <p>{{card.title}}</p>
                                                </div>

                                                <div class="addCard__text" v-if="card === editingCard">
                                                    <input type="text" class="text-input"
                                                           @keyup.enter="endEditingCard(card)" @blur="endEditingCard(card)" v-model="card.title"
                                                    >
                                                    <div class="addCard__button">
                                                        <button @click="endEditingCard(card)">Update Card</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </transition-group>
                                    </draggable>

                                    <div class="addCard__text" v-if="column.new.on === true">
                                        <input type="text" class="text-input" v-model="column.new.title">
                                        <div class="addCard__button">
                                            <button style="margin-right: 10px;" @click="saveNewCard(column)">Save</button>
                                            <i class="fas fa-times" @click="column.new.on = false"></i>
                                        </div>
                                    </div>


                                    <div class="todo-add__card" @click="column.new.on = true">
                                        <div class="add-icon">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <p>Add a card</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition-group>
                </draggable>

                <div class="todo-cards__wrapper">
                    <div class="todo-cards__card todo-header__list">
                        <div class="todo-cards__card-header">
                            <div v-if="new_column.on">
                                <input type="text" class="text-input full" v-model="new_column.title">
                                <div class="addCard__button">
                                    <button style="margin-right: 10px;" @click="saveNewColumn()">Save</button>
                                    <i class="fas fa-times" @click="new_column.on = false"></i>
                                </div>
                            </div>

                            <div v-else class="todo-add__card" @click="createNewColumn()">
                                <div class="add-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <p>Add New Column</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <CardModal name="CardModal" :height="380">
            <div class="card-modal-wrapper">
                <label for="story">Title</label>
                <input name="title" v-model="currentCard.title">

                <label for="story">Description</label>
                <textarea id="story" name="story" rows="5" cols="33" v-model="currentCard.description"></textarea>
                <hr>
                <button @click="updateCard(currentCard)">Update</button>
            </div>
        </CardModal>
    </div>

</template>

<script>
    import draggable from 'vuedraggable'
    // import CardModalView from '../components/CardModalView'

    export default {
        data() {
            return {
                columns: [],
                currentCard: [],
                editingColumn : null,
                editingCard : null,
                new_column: {
                    title: '',
                    on: false
                },
                drag: false,
                token: 'y4uKv64GvirOaRtqz0lPjFhWwQkccukN6hHhVdDWFqvJJs5AyftTnFTN2EWo',
                list_api_url: '/api/lists',
                card_api_url: '/api/cards'
            };
        },
        components: {
            draggable,
            // CardModalView,
        },
        mounted() {
            this.loadAllColumns()
        },
        methods : {
            loadAllColumns() {
                axios.get(this.list_api_url+'?api_token='+this.token).then(response => {
                    console.log(response)
                    response.data.data.forEach((data) => {
                        data.new = {on: false, title: ''}
                        this.columns.push(data)
                    })
                })
            },
            openCardModal(card) {
                this.currentCard = card
                this.$modal.show('CardModal')
            },
            changeColumnOrder(data) {
                let column_id = data.item.id
                let order = data.newIndex === data.oldIndex ? false : data.newIndex+1
                console.log('Order: ', order)
                if (order){
                    axios.post(this.list_api_url+'/'+column_id, {
                        api_token: this.token,
                        id: column_id,
                        order: order,
                    }).then(response => {})
                    console.log('Column Id: ', column_id)
                    console.log('Order: ', order)
                }


            },
            changeCardOrder(data) {
                let toTask = data.to
                let fromTask = data.from
                let task_id = data.item.id
                let column_id = fromTask.id === toTask.id ? null : toTask.id
                let order = data.newIndex === data.oldIndex && column_id === null ? false : data.newIndex+1

                if (order !== false) {
                    axios.post(this.card_api_url+"/"+task_id, {
                        api_token: this.token,
                        column_id: column_id,
                        order: order,
                    }).then(response => {})
                }
            },
            createNewColumn() {
                this.new_column.on = true
            },
            saveNewColumn() {
                this.new_column.on = false
                axios.post(this.list_api_url, {
                    api_token: this.token,
                    title: this.new_column.title
                }).then(response => {
                    response.data.data.new = {on: false, title: ''}
                    this.columns.push(response.data.data)
                    this.new_column.title = ''
                })
            },
            endEditingColumn(column) {
                this.editingColumn = null
                axios.post(this.list_api_url+'/'+column.id, {
                    api_token: this.token,
                    id: column.id,
                    title: column.title,
                }).then(response => {})
            },
            deleteColumn(column, column_index) {
                if(confirm("Do you really want to delete?")){
                    axios.post(this.list_api_url+'/delete/'+column.id, {
                        api_token: this.token,
                        id: column.id
                    }).then(response => {
                        this.columns.splice(column_index, 1);
                    })
                }
            },
            endEditingCard(card) {
                this.editingCard = null
                axios.post(this.card_api_url+"/"+card.id, {
                    api_token: this.token,
                    title: card.title,
                }).then(response => {})
            },
            updateCard(card) {
                this.$modal.hide('CardModal')
                axios.post(this.card_api_url+"/"+card.id, {
                    api_token: this.token,
                    title: card.title,
                    description: card.description,
                }).then(response => {})
            },
            saveNewCard(column) {
                if (column.new.title){
                    column.new.on = false;
                    axios.post(this.card_api_url, {
                        api_token: this.token,
                        title: column.new.title,
                        column_id: column.id
                    }).then(response => {
                        column.new.title = ''
                        column.cards.push(response.data.data)
                    })
                }

            },
            editColumn(column) {
                this.editingColumn = column
            },
            editCard(card) {
                this.editingCard = card
            }
        },
        computed: {
            dragOptions() {
                return {
                    animation: 1,
                    group: "description",
                    disabled: false,
                    ghostClass: "ghost"
                };
            }
        }
    }
</script>
