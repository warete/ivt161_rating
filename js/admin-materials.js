Vue.component('material-item', {
    template: '<div class="material-item">\n' +
    '            <div class="row">\n' +
    '                <div class="col-md-2">' +
    '                    <span>Название предмета</span>\n' +
    '                </div>' +
    '                <div class="col-md-3">\n' +
    '                    <strong class="text-warning">{{ data.name }}</strong>\n' +
    '                </div>\n' +
    '                <div class="col-md-2">' +
    '                    <span>Ссылка на материалы</span>\n' +
    '                </div>' +
    '                <div class="col-md-4">\n' +
    '                    <strong class="text-warning">{{ data.materials.join(", ") }}</strong>\n' +
    '                </div>\n' +
    '                <div class="col-md-1">\n' +
    '                    <button class="btn btn-danger btn-large btn-block mt-2 mt-md-0" v-on:click="$emit(\'remove\')"><span aria-hidden="true">&times;</span></button>\n' +
    '                </div>\n' +
    '            </div>\n' +
    '            <hr class="bg-light">' +
    '        </div>',
    props: ['data']
});

var app = new Vue({
    el: '#app',
    data: {
        newItem: {
            name: '',
            materials: '',
        },
        items: [],
    },
    computed: {
        nextId: function () {
            let items = this.items.sort((a, b) => a.id - b.id);
            return items[items.length - 1].id + 1;
        }
    },
    methods: {
        addNewMaterial: function () {
            this.items.push({
                id: this.nextId,
                name: this.newItem.name,
                materials: this.newItem.materials.split(', ')
            });
            this.newItem = {
                name: '',
                materials: '',
            };
        },
        saveMaterials: function () {
            axios
                .get('/admin/api/', {
                    params: {
                        action: "save-materials",
                        data: this.items
                    }
                });
        }
    },
    mounted() {
        axios
            .get('/data/materials.json')
            .then(response => (this.items = response.data.length ? response.data : []));
    }
});