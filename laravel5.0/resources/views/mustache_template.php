<template id="template-search-result">
    <tr class='result' item-ref='{{ref}}'>
        <td class='result-img'><img src="http://fourchetteandcie.com/pictures/{{ref_section}}/500px/{{ref}}.jpg" width="200px" height="200px"></td>
        <td class='result-details'>
            <p><span class='ref-box'>{{ref}}</span> {{name}}<br>
                <i>{{descr}}</i> ({{categ}})</p>
        </td>
        <td class='result-price'>
            <p>€ {{price}}</p>
        </td>
    </tr>
</template>

<template id="template-search-result-order-validation">
    <tr class='result' item-ref='{{ref}}'>
        <td class='result-img'></td>
        <td class='result-details'>
            <p><span class='ref-box'>{{ref}}</span> {{name}}<br>
                <i>{{descr}}</i> ({{categ}})</p>
        </td>
        <td class='result-price'>
            <p>€ {{price}}</p>
        </td>
    </tr>
</template>

<template id="template-order-validation-table-item">
    <tr item-ref='{{ref}}'>
        <td class='item-img'><img class='item-img' src='http://www.fourchetteandcie.com/pictures/{{img_path}}' height='50'></td>

        <td class='item-descr'><span class='ref-box'>{{ref}}</span> {{name}} <i>{{descr}}</i><br>
            <input class='edit-comment' type='text' name='comment-{{ref}}' placeholder='comment' value='{{comment}}'></td>

        <td class='item-qty'><div class='item-qty'><div class='item-qty-plus-button'>+</div> <div class='item-qty-value'>{{qty}}</div> <div class='item-qty-minus-button'>{{{minus_button}}}</div></div></td>

        <td class='item-unit-price edit-field'>{{currency}}<input class='edit-unit-price' type='text' name='unit-price-{{ref}}' value='{{price}}'></td>

        <td class='item-total'>{{currency}} {{total}}</td>
    </tr>
</template>

<template id="template-order-validation-table-totals">
    <tr id='search-add-item'>\n
        <td colspan='5'>
            <p id='search-info'>try <i>+{space}</i>, <i>#ref</i>, <i>&#36;section</i> or <i>@category</i>.</p>
            <div id='search-container'>
                <div id='search-box'>
                    <div id='search-tags'></div>
                    <div style='overflow: hidden'>
                        <input id='search-input' type='text' autocomplete='off' placeholder='search an item' >
                    </div>
                </div>
                <div id='results-box'><table> </table></div>
            </div>
        </td>
    </tr>

    <tr id='subtotal-row'>\n
        <td colspan='4'>SUBTOTAL ({{val_order_nb_items}} item{{nb_items_plural}})</td>
        <td>{{order_currency}} {{val_order_subtotal}}</td>
    </tr>

    {{#wholesale_subtotal}}
    <tr id='subtotal-row'>\n
        <td colspan='4'>WHOLESALE (-30%)</td>\n
        <td>{{order_currency}} {{wholesale_subtotal}}</td>
    </tr>
    {{/wholesale_subtotal}}

    <tr id='shipping-row'>
        <td colspan='4'>SHIPPING <input class='edit-shipping-details' type='text' name='shipping-details' placeholder='shipping details' value='{{val_order_shipping_details}}'></td>\n
        <td class='edit-field'>{{order_currency}} <input class='edit-shipping' type='text' name='shipping' value='{{val_order_shipping}}'></td>
    </tr>

    <tr id='total-row'>
        <td colspan='4'>TOTAL</td>
        <td>{{order_currency}} {{val_order_total}}</td>
    </tr>

    <tr id='message-row'>
        <td colspan='5'>Add a message:<br><textarea>{{val_order_message}}</textarea></td>\n
    </tr>";
</template>
