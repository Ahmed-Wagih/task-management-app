<template>
    <div class="container">
        <h1>Task Management</h1>
        <form @submit.prevent="createTask" class="mb-5">
            <div class="input-group mb-3">
                <input class="form-control" v-model="title" type="text" placeholder="Title" required>
                <textarea class="form-control" v-model="description" placeholder="Description"></textarea>
                <input class="form-control" v-model="status" type="text" placeholder="Status">
                <input class="form-control" v-model="userId" type="text" placeholder="User ID">
            </div>
            <button class="btn btn-success mt-2" type="submit">Create Task</button>
        </form>

        <table class="table table-hover border" border="1">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">description</th>
                    <th scope="col">status</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in tasks" :key="task.id">
                    <td>{{ task.title }}</td>
                    <td>{{ task.description }}</td>
                    <td>{{ task.status }}</td>
                    <td>{{ task.user_id }}</td>
                    <td>
                        <button class="btn btn-primary m-2" @click="editTask(task)">Edit</button>
                        <button class="btn btn-danger m-2" @click="deleteTask(task.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</template>
  
<script>
export default {
    data() {
        return {
            title: '',
            description: '',
            status: '',
            userId: '',
            tasks: [],
        };
    },
    mounted() {
        this.fetchTasks();
    },
    methods: {
        fetchTasks() {
            axios
                .get('/api/tasks')
                .then((response) => {
                    this.tasks = response.data.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        createTask() {
            axios
                .post('/api/tasks', {
                    title: this.title,
                    description: this.description,
                    status: this.status,
                    user_id: this.userId,
                })
                .then((response) => {
                    this.tasks.push(response.data);
                    this.resetForm();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        editTask(task) {
            // Implement edit functionality
        },
        deleteTask(taskId) {
            axios
                .delete(`/api/tasks/${taskId}`)
                .then(() => {
                    this.tasks = this.tasks.filter((task) => task.id !== taskId);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        resetForm() {
            this.title = '';
            this.description = '';
            this.status = '';
            this.userId = '';
        },
    },
};
</script>