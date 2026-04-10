<div v-bind:class="{'has_error': info.error}" v-if="info.show !== 'hide'">
    <label v-html="info.label" v-if="info.label"></label>
    <div class="file-input form-control" v-if="info.type == 'file'">
        <span class="file-name">{{info.value.name}}</span>
        <div class="file-upload" v-html="contract_data.i18n.upload"></div>
        <input @change="processFile($event, name)"
               :type="info.type"
               class="form-control" />
    </div>
    <input v-model="info.value"
           :type="info.type"
           :name="name"
           v-else
           class="form-control" />
    <div class="stm_input_alert" v-if="info.error" v-html="info.error"></div>
    <p v-html="info.description" v-if="info.description"></p>
</div>