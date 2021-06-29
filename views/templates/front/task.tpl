{extends file='page.tpl'}
{block name="page_content_container"}
    <div class="container">
        <select name="cats" id="cats">
            <option value="">{l s='- Select -' mod='multipurpose'}</option>
            {if isset($categories) && $categories}
                {foreach from=$categories item=$cat}
                    <option value="{$cat['id_category']}">{$cat['name']}</option>
                {/foreach}
            {/if}
        </select>
        <div class="ajax_products">

        </div>

        <table id="producttable" class="table table-hover">
            <thead>
                <tr>
                    <th>{l s='ID' mod='multipurpose'}</th>
                    <th>{l s='Product name' mod='multipurpose'}</th>
                    <th>{l s='Price' mod='multipurpose'}</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
{/block}