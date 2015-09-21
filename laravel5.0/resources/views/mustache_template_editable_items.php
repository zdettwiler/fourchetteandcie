<template id="template-editable-items">
    <div class='result' item-ref='{{ref}}' item-img-count='{{ img_count }}'>
        <div class='result-img'>
            <img src="http://fourchetteandcie.com/pictures/{{ref_section}}/500px/{{ref}}.jpg" width="200px" height="200px">
        </div>

        <div style="overflow: hidden">
        <div class="result-details">
            <span class="ref-box">{{ref}}</span>
            <span class="editable result-name" target="EDIT_NAME-{{ref}}" contenteditable="true">{{{name}}}</span><br>
            <span class="editable result-price" target="EDIT_PRICE-{{ref}}" contenteditable="true">{{price}}</span>
            <span class="editable result-descr" target="EDIT_DESCR-{{ref}}" contenteditable="true">{{{descr}}}</span><br>
            <span class="editable result-categ" target="EDIT_CATEG-{{ref}}" contenteditable="true">{{categ}}</span><br><br>

            <div class="is-or-not-{{is_new}} toggleable" target="TOGGLE_NEW-{{ref}}">
                <p>new</p>
                <img src="http://fourchetteandcie.com/pictures/{{is_new}}.png">
            </div>

            <div class="is-or-not-{{is_best_seller}} toggleable" target="TOGGLE_BEST_SELLER-{{ref}}">
                <p>b. seller</p>
                <img src="http://fourchetteandcie.com/pictures/{{is_best_seller}}.png">
            </div>

            <div class="is-or-not-{{is_sold_out}} toggleable" target="TOGGLE_SOLD_OUT-{{ref}}">
                <p>sold out</p>
                <img src="http://fourchetteandcie.com/pictures/{{is_sold_out}}.png">
            </div>
        </div>
        </div>
    </div>
</template>
