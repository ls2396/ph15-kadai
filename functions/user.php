<?php

function saveUser(array $user): array
{
    $handle = fopen(__DIR__ . '/../data/users.csv', 'a');

    $user['id'] = getNewId();
    // 这里调用 getNewId() 函数为新用户生成一个唯一的ID，并将这个ID存入 $user 数组中

    fputcsv($handle, [
        $user['id'],
        $user['name'],
        $user['email'],
        $user['password'],
        $user['birth'],
        $user['tel'],
        $user['address'],
        password_hash($user['password'], PASSWORD_DEFAULT),
    ]);

    fclose($handle);

    return $user;
}


function getUsers(): array
{
    $handle = fopen(__DIR__ . '/../data/users.csv', 'r');
    
    $users = [];

    while (!feof($handle)) {
        // 通过 while (!feof($handle)) 循环，逐行读取CSV文件的数据，直到文件结束
        $row = fgetcsv($handle);

        if ($row === false || is_null($row[0])) {
            break;
        }

        $user = [
            'id' => $row[0],
            'name' => $row[1],
            'email' => $row[2],
            'password' => $row[3],
            'birth' => $row[4],
            'tel' => $row[5],
            'address' => $row[6],
        ];

        $users[] = $user;
    }

    fclose(($handle));

    return $users;
}
// getUsers 函数读取一个存储在CSV文件中的用户数据，将每行的用户信息解析为数组，并最终返回一个由所有用户信息组成的数组


function getNewId(): int
// int:整数类型的值
{
    $maxId = 0;
    
    $users = getUsers();
    // 每个用户信息存储在一个关联数组中
    // 结构为 ['id' => ..., 'name' => ..., 'email' => ..., 'password' => ...]

    foreach ($users as $user) {
        $id = intval($user['id']);
        if ($id > $maxId) {
            $maxId = $id;
        }
    }

    return $maxId + 1;
}
// getNewId 函数的核心目的是根据已有用户的ID，生成一个新的唯一用户ID

function login(string $email, string $password): ?array
{
    $users = getUsers();

    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            // 使用 password_verify 来验证密码
            return $user;
        }
    }

    return null;
}

function getUser(string|int $id): ?array
{
    $users = getUsers();

    foreach ($users as $user) {
        if (intval($user['id']) === intval($id)) {
            return $user;
        }
    }

    return null;
}
// string：字符串  int（intval）：整数类型