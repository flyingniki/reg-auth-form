<?php

/** Приводит данные в безопасное представление (удаляет пробелы и очищает от html-тегов)
@param string $data
@return string результат
*/
function filterString($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

/** Приводит данные в безопасное представление (удаляет пробелы и очищает от html-тегов)
@param array $data
@return array результат
*/

function filterArray($data)
{
    $result = [];
    foreach ($data as $key => $value) {
        $result[$key] = filterString($value);
    }
    return $result;
}

/** Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
@param string $tmp_name Имя файла шаблона
@param array $data Ассоциативный массив с данными для шаблона
@return string Итоговый HTML
 */
function includeTemplate($tmpName, array $data = [])
{
    $tmpName = 'templates/' . $tmpName;
    if (!is_readable($tmpName)) {
        return;
    };
    ob_start();
    extract($data);
    require $tmpName;
    $result = ob_get_clean();
    return $result;
}

/** Устанавливает соединение с БД
@param array $config массив с параметрами конфигурации БД
@return mysqli ресурс соединения с БД
 */
function dbConnect($config)
{
    $conn = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database']);
    mysqli_options($conn, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
    if ($conn === false) {
        print("Ошибка подключения: " . mysqli_connect_error());
    } else {
        mysqli_set_charset($conn, "utf8");
    }
    return $conn;
}

/** Устанавливает запрос к БД и выводит результат в виде ассоциативного массива
@param mysqli $conn ресурс соединения с БД
@param string $sql SQL-запрос в виде строки
@return array ответ запроса в виде двумерного массива
 */
function dbQuery($conn, $sql)
{
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $error = mysqli_error($conn);
        print("Ошибка MySQL: " . $error);
    };
    $res_assoc = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $res_assoc;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } else if (is_string($value)) {
                $type = 's';
            } else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/** Процесс формирования запроса для получения списка пользователей
@param mysqli $conn - ресурс соединения с БД
@return array - ответ запроса в виде двумерного массива
 */
function getUsers(mysqli $conn)
{
    $sql = 'SELECT * FROM users u';
    return dbQuery($conn, $sql);
}

/** Сохраняет пользователя в БД
@param mysqli $conn ресурс соединения с БД
@param array $data данные из формы
@return mysqli_result|false результат запроса
 */
function addUsers($conn, $data)
{
    $dataArray = [
        $data['login'],
        $data['password'],
        $data['email'],        
        $data['name']
    ];

    $sql = 'INSERT INTO users (`login`, `password`, `email`, `name`) VALUES (?, ?, ?, ?)';

    $stmt = db_get_prepare_stmt($conn, $sql, $dataArray);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return $result;
}

/** Проверяет заполненность обязательных полей
@param string $field поле ввода
@return string|null  результат проверки
 */
function validateRequiredField($field)
{
    if (mb_strlen(trim($field)) == 0) {
        return 'Это поле должно быть заполнено';
    }
    return null;
}

/** Проверка email в форме регистрации
@param string $email введеный email
@param array $users список пользователей
@return string|null результат валидации
 */
function validateRegEmail($email, $users)
{
    if (!validateRequiredField($email)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            foreach ($users as $user) {
                if ($email === $user['email']) {
                    return 'Пользователь с таким e-mail уже существует';
                    break;
                }
                return null;
            }
        } else {
            return 'E-mail введён некорректно';
        }
    }
    return validateRequiredField($email);
}

/** Получение ID пользователя из сессии
@return int ID пользователя
*/
function getUserIdFromSession()
{
    $userId = $_SESSION['user']['userId'] ?? null;
    return $userId;
}

/** Получает и фильтрует данные из формы для последующей валидации
@return array результат фильтрации
 */
function getRegisterFormData()
{
    $result = [];
    $result['login'] = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
    $result['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
    $result['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
    $result['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
    return $result;
}

/** Валидация формы регистрации на ошибки
@param array $users список пользователей
@return array|null результат валидации
 */
function validateRegisterForm($users)
{
    $result = getRegisterFormData();

    $errors = [
        'login' => validateRequiredField($result['login']),
        'email' => validateRegEmail($result['email'], $users),
        'password' => validateRequiredField($result['password']),
        'name' => validateRequiredField($result['name'])
    ];

    $errors = array_filter($errors);
    //echo 'Ошибки: ';
    //print_r($errors);
    return $errors;
}