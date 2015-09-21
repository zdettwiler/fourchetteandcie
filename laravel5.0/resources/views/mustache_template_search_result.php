<template id="template-search-result">
    <tr class='result' item-ref='{{ref}}'>
        <td class='result-img'><img src="http://fourchetteandcie.com/pictures/{{ref_section}}/500px/{{ref}}.jpg" width="200px" height="200px"></td>
        <td class='result-details'>
            <p><span class='ref-box'>{{ref}}</span> {{{name}}}<br>
                <i>{{{descr}}}</i> ({{categ}})</p>
        </td>
        <td class='result-price'>
            <p>€ {{price}}</p>
        </td>
    </tr>
</template>
