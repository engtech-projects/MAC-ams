<script>
    Vue.component("select-branch", {
        template: '<div>' + '<select required @change="setBranch" v-model="branch_id" class="form-control form-control-sm">' +
            '<option value="" disabled selected>@{{ defaultSelected }}</option>' +
            '<option v-for="item in branches" v-bind:value="item.branch_id">@{{ item.branch_name }}</option></select></div>',
        props: ["data"],
        data() {
            return {
                branches: null,
                defaultSelected: 'Select Branch',
                branch_id: '',
            };
        },
        methods: {
            setBranch(event) {
                this.$emit('setselectedbranch',event.target.value)
            },
            async getBranchList() {
                axios.get('/branch').then((response) => {
                    this.branches = response.data.data
                }).catch((err) => {
                    console.error(err);
                });
            },
        },
        mounted() {
            this.getBranchList()
        },
    });
</script>
