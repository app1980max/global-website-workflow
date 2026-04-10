window.addEventListener('load', function () {

    Vue.component('v-select', VueSelect.VueSelect);

    let vue_obj = {
        el: '#crypterio-contract',
        data: {
            balance: 0,
            contract_data: {},
            popup: false,
            agreement_1: false,
            agreement_2: false,
            completed: false,
            submitting: false,
            recaptcha: '',
            captcha_error: '',
            // currency_1_rate: 0,
            // currency_2_rate: 0,
            raised_currency_1: 0,
            raised_currency_2: 0
        },
        created: function() {
            this.contract_data = stm_contract_data;
        },
        mounted: function () {

            var contract = this.contract_data.contract;

            if(contract && contract !== 'stylemix') {

                if (typeof web3 !== 'undefined') {
                    web3 = new Web3(web3.currentProvider);
                } else {
                    // set the provider you want from Web3.providers
                    var provider = 'https://mainnet.infura.io/v3/e186097359214e95a975e4420b24568b';
                    web3 = new Web3(new Web3.providers.HttpProvider(provider));
                }

                this.balance = this.parse_round(web3.eth.getBalance(contract) / 1000000000000000000);

            } else {
                /*For demo purposes*/
                this.balance = 98.235;
            }


            var softcap = this.contract_data.softcap;
            var hardcap = this.contract_data.hardcap;
            var eth_rate = this.contract_data.eth_rate;
            var balance = this.contract_data.balance_usd = this.parse_round(this.balance * eth_rate, 2);

            if(balance < softcap) {
                this.contract_data.hardcap_label = this.contract_data.softcap_label;
                this.contract_data.hardcap_label_2 = this.contract_data.softcap_label_2;
                this.contract_data.completed = this.parse_round((balance * 100) / softcap);
            } else {
                this.contract_data.hardcap_label = this.contract_data.hardcap_label;
                this.contract_data.hardcap_label_2 = this.contract_data.hardcap_label_2;

                this.contract_data.completed = this.parse_round((balance * 100) / hardcap);
            }

            this.raised_currency_1 = this.contract_data.balance_usd / this.contract_data.currencie_1_rate;
            this.raised_currency_2 = this.contract_data.balance_usd / this.contract_data.currencie_2_rate;

            this.raised_currency_1 = this.raised_currency_1.toFixed(this.contract_data.round);
            this.raised_currency_2 = this.raised_currency_2.toFixed(this.contract_data.round);

            this.contract_data.balance_usd = this.price_format(this.contract_data.balance_usd);

        },
        methods : {
            parse_round(value, fixed) {
                if(typeof fixed === 'undefined') fixed = 3;
                return parseFloat(value.toFixed(fixed));
            },
            price_format(value) {
                return '$' + value.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
            },
            openPopup(e) {
                e.preventDefault();
                jQuery('body').toggleClass('locked');
                this.popup = !this.popup;
            },
            processFile(e, name) {
                var file = (e.target.files.length) ? e.target.files[0] : '';
                this.contract_data.user_data[name].value = file;
            },
            submitData() {
                var $ = jQuery;
                var fd = new FormData;
                var $this = this;


                for(var name in this.contract_data.user_data) {
                    if (!this.contract_data.user_data.hasOwnProperty(name)) continue;
                    fd.append(name, this.contract_data.user_data[name].value);
                }

                fd.append('action', 'stm_whitelist_data');

                fd.append('security', window.wp_data.stm_whitelist_data);

                fd.append('recaptcha', $this.recaptcha);

                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        for(var name in $this.contract_data.user_data) {
                            $this.$set($this.contract_data.user_data[name], 'error', false);
                        }
                        $this.$set($this, 'submitting', true);
                    },
                    success: function (data) {
                        $this.$set($this, 'submitting', false);

                        if(data.has_error) {
                            for(var name in data.errors) {
                                $this.$set($this.contract_data.user_data[name], 'error', data.errors[name]);
                            }
                        }

                        if(data.error_message) {
                            $this.captcha_error = data.error_message;
                        }

                        if(data.success) {
                            $this.$set($this, 'completed', '<i class="fas fa-thumbs-up"></i>' + data.success);
                        }
                    }
                });
            },
            onCaptchaVerified(recaptchaToken) {
                this.recaptcha = recaptchaToken;
                this.captcha_error = false;
            },
            onCaptchaExpired() {
                this.recaptcha = '';
            }
        }
    };

    if(typeof VueRecaptcha !== 'undefined') {
        vue_obj['components'] = {VueRecaptcha};
    }

    new Vue(vue_obj);
});