<template>
    <div class="mail-container col-6 offset-sm-3">
        <h3 class="mb-3">Testing Draggable Package</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                </tr>
            </thead>
            <!-- <tbody>
                <template v-for="(category, index) in categories">
                    <tr :key="index">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                    </tr>
                </template>
            </tbody> -->
            <draggable tag="tbody" v-model="categories" @change="onDrop">
                <template v-for="(category, index) in categories">
                    <tr :key="index">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                    </tr>
                </template>
            </draggable>
        </table>
    </div>
</template>

<script>

    import draggable from 'vuedraggable'

    export default {
        name: 'drag',

        components: {
            draggable,
        },
        
        mounted() {
            // this.getCategories();
            console.log("Hello, Vue!");
        },

        data() {
            return {
                categories: [
                    {
                        id: 1,
                        name: "Sherali",
                        children: [
                            {
                                id: 100,
                                name: "Julia"
                            },
                            {
                                id: 101,
                                name: "Ivan"
                            },
                            {
                                id: 102,
                                name: "Kirill"
                            }
                        ]
                    },
                    {
                        id: 2,
                        name: "Akim",
                        children: [
                            {
                                id: 103,
                                name: "Vasiliy"
                            },
                            {
                                id: 104,
                                name: "Vlad"
                            },
                            {
                                id: 105,
                                name: "Ivan"
                            }
                        ]
                    },
                    {
                        id: 2,
                        name: "Julia",
                        children: [
                            {
                                id: 104,
                                name: "Mariya"
                            },
                            {
                                id: 105,
                                name: "Alexandra"
                            },
                            {
                                id: 106,
                                name: "Pavel"
                            }
                        ]
                    }
                ]
            }
        },

        methods: {
            getCategories() {
                let self = this;

                axios.get('/api/categories')
                    .then(res => {
                        self.categories = res.data;
                    })
            },
            
            onDrop(data) {
                console.log(data.moved);
            }
        }
    }

</script>

