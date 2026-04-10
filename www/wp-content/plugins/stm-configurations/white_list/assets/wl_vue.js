window.addEventListener('load', function () {

    if(typeof wl_i18n === 'undefined') return;

    var list_data = ajaxurl + '?action=stm_wl';
    var change_status = ajaxurl + '?action=stm_wl_change_status';

    new Vue({
        el: '#white_list',
        data: {
            list: [],
            i18n: wl_i18n,
            filter: '',
            pages: [],
            current_page: 1,
            total: 0,
            loading: false
        },
        mounted: function () {
            this.filterList(false);
        },
        methods : {
            filterList(filtered) {
                this.loading = true;
                this.$http.get(list_data + '&status=' + this.filter + '&page=' + this.current_page + '&security=' + window.wp_data.stm_wl ).then(function (response) {
                    this.list = response.body;
                    this.total = Math.ceil(parseInt(response.body.total) / parseInt(response.body.per_page));
                    this.pagination();
                    this.loading = false;
                });
            },
            pagination() {
                this.pages = [];
                var i = 0;
                while (i < this.total) {
                    i++;
                    this.pages.push(i);
                }
            },
            switchPage(page) {
                this.current_page = page;
                this.filterList();
            },
            status(status, loading) {
                switch(status) {
                    case (this.i18n.declined) :
                        status = 'declined';
                        break;
                    case (this.i18n.approved) :
                        status = 'approved';
                        break;
                    default:
                        status = 'pending';
                }

                if(loading) {
                    status += ' loading';
                }

                return status;
            },
            changeStatus(e, post_id, status, key) {
                e.preventDefault();
                var $this = this;
                post_id = parseInt(post_id);

                $this.$set($this.list['posts'][key], 'loading', true);

                this.$http.get(this.getAjaxStatusUrl(post_id, status)).then(function (response) {
                    var r = response.data;
                    $this.$set($this.list['posts'][key], 'status', r.status);
                    $this.$set($this.list['posts'][key], 'loading', false);
                });
            },
            getAjaxStatusUrl(post_id, status) {
                return change_status + '&status=' + status + '&post_id=' + post_id;
            },
        },
    })
});