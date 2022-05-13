<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <style>
            [v-cloak] {
                display: none !important;
            }
        </style>
        <script>
            window.__INITIAL_STATE__ = "{!! addslashes(json_encode($state ?? [])) !!}"
        </script>
    </head>
    <body>
        <main v-cloak id="app">
            <div class="p4 my-5 text-center">
                <h1 class="display-5 fw-bold">Добро пожаловать, @{{ user.name }}</h1>
                <form method="post" action="{{ route('change-user') }}"><button type="submit" class="btn btn-secondary btn-lg px-4 gap-3">Изменить пользователя</button>@csrf</form>
            </div>
            <div class="p-4 my-5 text-center">
                <div v-html="lastRollHtml" class="display-5 fw-bold text-white rounded mb-3" :class="lastRollClass"></div>
                <button @click="roll" type="button" class="btn btn-primary btn-lg px-4 gap-3">Крутить рулетку</button>
            </div>
            <div class="p-4 my-5 text-center">
                <button @click="loadUsersPerRolls" type="button" class="btn btn-primary btn-lg px-4 gap-3">Раунды</button>
                <table v-if="Object.keys(usersPerRolls).length" class="table">
                    <thead>
                        <tr>
                            <th scope="col">Раунд</th>
                            <th scope="col">Пользователи</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(value, name, index) in usersPerRolls">
                            <th scope="row">@{{ name }}</th>
                            <td>@{{ value }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-4 my-5 text-center">
                <button @click="loadActiveUsers" type="button" class="btn btn-primary btn-lg px-4 gap-3">Активные пользователи</button>
                <table v-if="activeUsers.length" class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Раунды</th>
                            <th scope="col">Прокручивания за раунд</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in activeUsers">
                            <th scope="row">@{{ user.id }}</th>
                            <td>@{{ user.name }}</td>
                            <td>@{{ user.gamesCount }}</td>
                            <td>@{{ user.avgRolls }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>

        <script src="https://unpkg.com/vue@3"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            const initialState = JSON.parse(window.__INITIAL_STATE__) || {};
            const {createApp} = Vue

            createApp({
                data() {
                    return {
                        user: initialState.user,
                        lastRoll: initialState.lastRoll,
                        usersPerRolls: {},
                        activeUsers: []
                    }
                },
                computed: {
                    lastRollHtml: function () {
                        return !this.lastRoll ? '&nbsp;' : (this.lastRoll !== 11 ? this.lastRoll : 'Jackpot');
                    },
                    lastRollClass: function () {
                        return this.lastRoll % 2 === 0 ? 'bg-black' : 'bg-danger';
                    },
                },
                methods: {
                    roll: function () {
                        axios
                            .post('{{ route('roll') }}')
                            .then(response => {
                                this.lastRoll = response.data;
                            })
                    },
                    loadUsersPerRolls: function () {
                        axios
                            .get('{{ route('users-per-rolls') }}')
                            .then(response => {
                                this.usersPerRolls = response.data;
                                console.log(Object.keys(this.usersPerRolls).length);
                            })
                    },
                    loadActiveUsers: function () {
                        axios
                            .get('{{ route('active-users') }}')
                            .then(response => {
                                this.activeUsers = response.data;
                                console.log(this.activeUsers);
                            })
                    }
                },
            }).mount('#app')
        </script>
    </body>
</html>
