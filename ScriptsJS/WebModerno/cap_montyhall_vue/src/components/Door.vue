<template>
    <div class="door-area">
        <div class="door-frame" :class="{selected : selected && !open}">
            <Gift v-if="open && hasGift"/>
        </div>
        <div class="door" @click="selected = !selected" :class="{open}">
            <div class="number" :class="{selected}">{{number}}</div>
            <div class="knob" :class="{selected}" @click.stop="open = true"></div>
        </div>
    </div>
</template>

<script>
    import Gift from './Gift';

    export default {
        name: "Door",
        components: {Gift},
        props: {
            number: {},
            hasGift: {type: Boolean}
        },
        data: function () {
            return {
                open: false,
                selected: false
            }
        }
    }
</script>

<style>

    :root {
        --door-border: 5px solid brown;
        --selected-border: 5px solid yellow;
    }

    .door-area {
        position: relative;
        width: 200px;
        height: 310px;
        border-bottom: 10px solid #AAA;
        margin-bottom: 20px;
        font-size: 3rem;
        display: flex;
        justify-content: center;
    }

    .door-frame {
        position: absolute;
        height: 300px;
        width: 180px;
        display: flex;
        justify-content: center;
        align-items: flex-end;
        border-left: var(--door-border);
        border-right: var(--door-border);
        border-top: var(--door-border);
    }

    .door {
        position: absolute;
        top: 5px;
        width: 170px;
        height: 295px;
        display: flex;
        background-color: chocolate;
        flex-direction: column;
        padding: 15px;
        align-items: center;
    }

    .door .knob {
        height: 20px;
        width: 20px;
        border-radius: 10px;
        background-color: brown;
        align-self: flex-start;
        margin-top: 60px;
    }

    .door-frame.selected {
        border-left: var(--selected-border);
        border-right: var(--selected-border);
        border-top: var(--selected-border);
    }

    .door > .number.selected {
        color: yellow;
    }

    .door > .knob.selected {
        background-color: yellow;
    }

    .door.open{
        background-color: #0007;
    }

    .door.open .number,
    .door.open .knob{
        display: none;
    }

</style>