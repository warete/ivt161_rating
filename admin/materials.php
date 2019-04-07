<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/include/prolog.php";
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактирование раздела "Материалы"</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="bg-dark text-light">
    <div class="container" id="app">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8">
                <h1>Редактирование раздела "Материалы"</h1>
            </div>
            <div class="col-md-4">
                <button class="btn btn-success btn-block float-right" @click="saveMaterials">Сохранить</button>
            </div>
        </div>
        <div class="material-item mt-4">
            <div class="form-group row">
                <div class="col-md-2">
                    <span>Название предмета</span>
                </div>
                <div class="col-md-3">
                    <input
                        v-model="newItem.name"
                        type="text"
                        class="form-control"
                    >
                </div>
                <div class="col-md-2">
                    <span>Ссылка на материалы</span>
                </div>
                <div class="col-md-4">
                    <input
                        v-model="newItem.materials"
                        type="text"
                        class="form-control"
                    >
                </div>
                <div class="col-md-1">
                    <button class="btn btn-success btn-large btn-block mt-2 mt-md-0" v-on:click="addNewMaterial">+</button>
                </div>
            </div>
            <hr class="bg-light">
        </div>
        <material-item
            v-for="(item, index) in items"
            :key="item.id"
            :data="item"
            @remove="items.splice(index, 1)"
        ></material-item>
    </div>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="/js/admin-materials.js"></script>
</body>
</html>

