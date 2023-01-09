<template>
    <section>
        <div class="todo-cards">

            <div class="todo-cards__wrapper" v-for="column in columns">
                <div class="todo-cards__card">
                    <div class="todo-cards__card-header">
                        <div class="todo-box__item" data-state="editable">
                            <div class="todo-box__item-text" contenteditable="true">
                                {{ column.title }}
                            </div>
                            <div class="close-icon">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>

                        <draggable class="draggable-list" :list="column.cards" group="my-group" :component-data="getComponentData()"
                                   :moved="onMove"  @start="drag = true"
                                   @end="drag = false"
                        >
                            <!--                                <transition-group type="transition" :name="!drag ? 'flip-list' : null">-->
                            <div class="todo-sample__card" v-for="card in column.cards" :key="card.title">
                                <div class="pencil-icon">
                                    <i class="fas fa-pencil-alt"></i>
                                </div>
                                <p>{{card.title}}</p>
                            </div>
                            <!--                                </transition-group>-->
                        </draggable>

                        <div class="addCard__text">
                            <input type="textarea" value="" />
                            <div class="addCard__button">
                                <button>Add Card</button>
                                <i></i>
                            </div>
                        </div>
                        <div class="todo-add__card">
                            <div class="add-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <p>Add a card</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="todo-cards__wrapper">
                <div class="todo-cards__card todo-header__list">
                    <div class="todo-cards__card-header">
                        <div class="todo-add__card">
                            <div class="add-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <p>Add a card</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

</script>
