<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Router;
use Phalcon\Http\Response;
use Phalcon\Db\Adapter\Pdo\Sqlite;
use Phalcon\Db\Column as Column;

$app = new Micro();

// Setup the database service
$app['db'] = function () {
    return new Sqlite(
        ["dbname" => "./public/users.sqlite",]
    );
};

$app->post(
    '/api',
    function () use ($app) {
        if ($app->request->isPost()) {

            $response = new Response();
            $data = $app->request->getRawBody();
            $data = json_decode($data, true);
            $params = $data['params'];
            $jsonrpc = $data['jsonrpc'];
            $method = $data['method'];
            $id = $data['id'];

            if ($method == 'authorize') {
                $sql = "SELECT * FROM users;";
                $users = $app['db']->fetchOne($sql);

                $response->setContentType('application/json', 'UTF-8');
                if ($users['login'] != $params['login'] || $users['password'] != $params['password']) {
                    $resp = $response->setJsonContent(array(
                        'version' => '2.0',
                        'result' => 'неверный логин или пароль',
                        'error' => true,
                        'id' => '1'
                    ))->send();
                } else {
                    $resp = $response->setJsonContent(array(
                        'version' => '2.0',
                        'result' => 'успешная авторизация',
                        'error' => false,
                        'id' => '1'
                    ))->send();

                }
                return $resp;
            }

        }
    }
);

$app->get(
    '/migrate',
    function () use ($app) {
        $app['db']->createTable(
            "users",
            null,
            array(
                "columns" => array(
                    new Column("login",
                        array(
                            "type" => Column::TYPE_VARCHAR,
                            "size" => 10,
                            "notNull" => true,
                        )
                    ),
                    new Column("password",
                        array(
                            "type" => Column::TYPE_VARCHAR,
                            "size" => 10,
                            "notNull" => true,
                        )
                    )
                )
            )
        );

        //$tables = $app['db']->listTables('users');
        //var_dump($tables);
        //$exists = $app['db']->tableExists('users');
        //var_dump($exists);

        $sql = "INSERT INTO `users`(`login`, `password`) VALUES ('admin', 'admin')";
        $app['db']->query(
            $sql,
            []
        );

        echo "<h1>Install ok</h1>";
    }
);


$app->handle();
