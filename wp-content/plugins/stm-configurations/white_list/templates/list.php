<div class="white_list" id="white_list" v-bind:class="{'loading' : loading}">

    <i class="fa fa-refresh fa-spin"></i>

    <div class="inner">
        <div class="row">
            <div class="column">
                <div class="filter">
                    {{i18n.filter}}
                    <select v-model="filter" v-on:change="filterList(true)">
                        <option value="">{{i18n.all}}</option>
                        <option value="publish">{{i18n.approved}}</option>
                        <option value="trash">{{i18n.declined}}</option>
                        <option value="pending">{{i18n.pending}}</option>
                    </select>
                </div>
            </div>
            <div class="column">
                <a href="<?php echo esc_url(add_query_arg(array('stm_export_wl' => 'export'), admin_url())); ?>"
                   target="_blank"
                   class="button float-right"><?php esc_html_e('Export CSV', 'crypterio'); ?></a>
            </div>
        </div>

        <table>

            <thead>
            <tr>
                <th>{{i18n.name}}</th>
                <th>{{i18n.email}}</th>
                <th>{{i18n.details}}</th>
                <th>{{i18n.status}}</th>
                <th>{{i18n.actions}}</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="(user, key) in list.posts" v-bind:class="status(user.status, user.loading)">
                <td class="name">
                    <a v-bind:href="user.edit_url" target="_blank" v-if="user.status != i18n.declined">
                        {{user.title}}
                    </a>
                    <span v-else>{{user.title}}</span>
                </td>
                <td class="email">{{user.email}}</td>
                <td class="details">
                    <div>{{i18n.country}}: <strong>{{user.country}}</strong></div>
                    <div>{{i18n.amount}}: <strong>{{user.amount}}</strong></div>
                    <div>{{i18n.wallet}}: <strong>{{user.wallet}}</strong></div>
                    <div>
                        <i class="fa fa-refresh fa-spin"></i>
                        <a v-bind:href="user.front_photo" target="_blank">
                            {{i18n.doc1}}
                        </a>
                        <a v-bind:href="user.back_photo" target="_blank" v-if="user.back_photo">
                            {{i18n.doc2}}
                        </a>
                    </div>
                </td>
                <td class="status">{{user.status}}</td>
                <td class="actions">
                    <a href="#"
                       class="button approve"
                       v-on:click="changeStatus($event, user.ID, 'publish', key)"
                       v-if="user.status != i18n.approved">
                        {{i18n.approve}}
                    </a>
                    <a href="#"
                       class="button decline"
                       v-on:click="changeStatus($event, user.ID, 'trash', key)"
                       v-if="user.status == i18n.approved || user.status == i18n.pending">
                        {{i18n.decline}}
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="pagination" v-if="total > 1">
            <a href="#"
               v-for="page in pages"
               v-on:click="switchPage(page)"
               v-bind:class="{'active' : page == current_page}">{{page}}</a>
        </div>
    </div>

</div>